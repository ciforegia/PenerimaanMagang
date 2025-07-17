<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Direktorat;
use App\Models\Divisi;
use App\Models\InternshipApplication;
use App\Models\Assignment;
use App\Models\Certificate;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the participant dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        // Update otomatis status menjadi finished jika end_date sudah lewat
        $user->internshipApplications()
            ->where('status', 'accepted')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'finished']);
        if ($user->role === 'pembimbing') {
            return redirect('/mentor/dashboard');
        }
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->first();
        if (!$application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat')
                ->latest()
                ->first();
        }
        return view('dashboard.index', compact('user', 'application'));
    }

    /**
     * Display the application status.
     */
    public function status()
    {
        $user = Auth::user();
        // Update otomatis status menjadi finished jika end_date sudah lewat
        $user->internshipApplications()
            ->where('status', 'accepted')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'finished']);
        \Log::info('User ID: ' . $user->id);
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->first();
        \Log::info('Application ID: ' . ($application ? $application->id : 'null') . ' | Status: ' . ($application ? $application->status : 'null'));
        if (!$application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat')
                ->latest()
                ->first();
        }
        return view('dashboard.status', compact('user', 'application'));
    }

    /**
     * Display assignments and grades.
     */
    public function assignments()
    {
        $user = Auth::user();
        $assignments = $user->assignments()->orderBy('created_at', 'desc')->get();
        
        // Ambil pengajuan terbaru yang statusnya pending/accepted
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->first();
        if (!$application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat')
                ->latest()
                ->first();
        }

        return view('dashboard.assignments', compact('user', 'assignments', 'application'));
    }

    /**
     * Submit assignment.
     */
    public function submitAssignment(Request $request, $id)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'online_text' => 'nullable|string',
        ]);

        $assignment = Assignment::findOrFail($id);
        if ($assignment->user_id !== Auth::id()) {
            abort(403);
        }

        $data = [
            'submitted_at' => now(),
        ];
        if ($request->hasFile('submission_file')) {
            $filePath = $request->file('submission_file')->store('assignments', 'public');
            $data['submission_file_path'] = $filePath;
            // Simpan ke tabel assignment_submissions
            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'user_id' => Auth::id(),
                'file_path' => $filePath,
                'submitted_at' => now(),
                'keterangan' => 'Kumpul tugas' . ($assignment->submissions()->count() > 0 ? ' (Revisi)' : ''),
            ]);
        }
        if ($request->filled('online_text')) {
            $data['online_text'] = $request->online_text;
        }
        $assignment->update($data);
        // Jika assignment sebelumnya status revisi, reset is_revision setelah submit revisi
        if ($assignment->is_revision === 1) {
            $assignment->is_revision = null;
            $assignment->save();
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Display certificates.
     */
    public function certificates()
    {
        $user = Auth::user();
        $certificates = collect();
        $latestApp = $user->internshipApplications()->whereIn('status', ['accepted', 'finished'])->latest()->first();
        if ($latestApp && $latestApp->end_date && now()->isAfter($latestApp->end_date)) {
            $certificates = $user->certificates()->orderBy('created_at', 'desc')->get();
        }
        return view('dashboard.certificates', compact('user', 'certificates'));
    }

    /**
     * Download certificate.
     */
    public function downloadCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($certificate->certificate_path)) {
            return Storage::disk('public')->download($certificate->certificate_path);
        }

        abort(404);
    }

    /**
     * Display internship program.
     */
    public function program()
    {
        $user = Auth::user();
        $direktorats = Direktorat::with(['subDirektorats.divisis'])->get();
        $hasAccepted = (bool) $user->internshipApplications()
            ->where('status', 'accepted')
            ->exists();
        $hasCertificate = (bool) $user->certificates()->exists();
        
        return view('dashboard.program', compact('user', 'direktorats', 'hasAccepted', 'hasCertificate'));
    }

    /**
     * Show re-application form for existing users.
     */
    public function reapply(Request $request)
    {
        $user = Auth::user();
        $divisis = Divisi::with('subDirektorat.direktorat')->get();
        $selectedDivisi = null;
        
        if ($request->has('divisi')) {
            $selectedDivisi = Divisi::with('subDirektorat.direktorat')->find($request->divisi);
        }
        
        return view('dashboard.reapply', compact('user', 'divisis', 'selectedDivisi'));
    }

    /**
     * Handle re-application submission.
     */
    public function submitReapply(Request $request)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
            'cover_letter' => 'required|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();

        // Handle file upload
        if ($request->hasFile('cover_letter')) {
            $path = $request->file('cover_letter')->store('cover_letters', 'public');
        }

        // Create new internship application
        InternshipApplication::create([
            'user_id' => $user->id,
            'divisi_id' => $request->divisi_id,
            'status' => 'pending',
            'cover_letter_path' => $path ?? null,
        ]);

        return redirect('/dashboard')->with('success', 'Pengajuan ulang berhasil dikirim! Status akan diperbarui segera.');
    }
}
