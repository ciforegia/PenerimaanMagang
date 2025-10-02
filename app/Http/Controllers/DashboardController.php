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
            ->whereIn('status', ['pending', 'accepted', 'finished'])
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
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted', 'finished'])
            ->latest()
            ->first();
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
        
        // Ambil pengajuan terbaru yang statusnya pending/accepted/finished
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted', 'finished'])
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
        // Tampilkan sertifikat hanya jika end_date sudah lewat
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
            $user = Auth::user();
            $filename = 'Sertifikat_' . str_replace(' ', '_', $user->name) . '_' . $user->nim . '.pdf';
            return Storage::disk('public')->download($certificate->certificate_path, $filename);
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
        
        // Check if user has any accepted or finished applications
        $hasAccepted = (bool) $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->exists();
            
        // Check if user has any finished applications (completed internships)
        $hasFinished = (bool) $user->internshipApplications()
            ->where('status', 'finished')
            ->exists();
            
        $hasCertificate = (bool) $user->certificates()->exists();
        
        return view('dashboard.program', compact('user', 'direktorats', 'hasAccepted', 'hasFinished', 'hasCertificate'));
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
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after' => 'Tanggal mulai harus setelah hari ini.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        $user = Auth::user();

        // Create new internship application
        InternshipApplication::create([
            'user_id' => $user->id,
            'divisi_id' => $request->divisi_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')->with('success', 'Pengajuan ulang berhasil dikirim! Status akan diperbarui segera.');
    }

    public function acknowledgePersyaratanTambahan(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();
        if ($application) {
            $application->acknowledged_additional_requirements = true;
            $application->save();
        }
        return redirect()->route('dashboard.status');
    }

    public function submitAdditionalDocuments(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();
        if (!$application) {
            return redirect()->route('dashboard.status')->with('error', 'Tidak ada pengajuan yang diterima.');
        }
        $request->validate([
            'cover_letter' => 'required|file|mimes:pdf|max:2048',
            'foto_nametag' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'screenshot_pospay' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_prangko_prisma' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_follow_ig_museum' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_follow_ig_posindonesia' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_subscribe_youtube' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // Upload files
        $application->cover_letter_path = $request->file('cover_letter')->store('cover_letters', 'public');
        $application->foto_nametag_path = $request->file('foto_nametag')->store('additional_docs', 'public');
        $application->screenshot_pospay_path = $request->file('screenshot_pospay')->store('additional_docs', 'public');
        $application->foto_prangko_prisma_path = $request->file('foto_prangko_prisma')->store('additional_docs', 'public');
        $application->ss_follow_ig_museum_path = $request->file('ss_follow_ig_museum')->store('additional_docs', 'public');
        $application->ss_follow_ig_posindonesia_path = $request->file('ss_follow_ig_posindonesia')->store('additional_docs', 'public');
        $application->ss_subscribe_youtube_path = $request->file('ss_subscribe_youtube')->store('additional_docs', 'public');
        $application->save();
        return redirect()->route('dashboard.status')->with('success', 'Dokumen tambahan berhasil dikumpulkan!');
    }

    public function downloadAcceptanceLetter()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()->whereIn('status', ['accepted', 'finished'])->latest()->first();
        if ($application && $application->acceptance_letter_path && Storage::disk('public')->exists($application->acceptance_letter_path)) {
            $filename = 'Surat Penerimaan_' . str_replace(' ', '_', $user->name) . '_' . $user->nim . '.pdf';
            return Storage::disk('public')->download($application->acceptance_letter_path, $filename);
        }
        abort(404);
    }

    public function downloadAcceptanceLetterFlag(Request $request)
    {
        $user = auth()->user();
        $application = $user->internshipApplications()->where('status', 'accepted')->latest()->first();
        if ($application) {
            $application->acceptance_letter_downloaded_at = now();
            $application->save();
        }
        session(['download_acceptance_letter' => true]);
        return response()->json(['success' => true]);
    }
}
