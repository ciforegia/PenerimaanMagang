<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorDashboardController extends Controller
{
    public function index()
    {
        return view('mentor.dashboard');
    }

    public function pengajuan()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $applications = $divisi ? $divisi->internshipApplications()->with('user')->orderBy('created_at', 'desc')->get() : collect();
        return view('mentor.pengajuan', [
            'applications' => $applications
        ]);
    }

    public function penugasan()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $acceptedParticipants = $divisi
            ? \App\Models\InternshipApplication::with(['user.assignments' => function($q) { $q->orderBy('created_at', 'desc'); }])
                ->where('divisi_id', $divisi->id)
                ->where('status', 'accepted')
                ->get()
            : collect();
        return view('mentor.penugasan', [
            'participants' => $acceptedParticipants
        ]);
    }

    public function sertifikat()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $participants = $divisi
            ? \App\Models\InternshipApplication::with(['user.assignments', 'user.certificates'])
                ->where('divisi_id', $divisi->id)
                ->whereIn('status', ['accepted', 'finished'])
                ->get()
            : collect();
        
        // Update otomatis status menjadi finished jika end_date sudah lewat
        $participants->each(function($p) {
            if ($p->status === 'accepted' && $p->end_date && now()->isAfter($p->end_date)) {
                $p->status = 'finished';
                $p->save();
            }
        });
        
        // Tambahkan status selesai magang (hanya berdasarkan end_date)
        $participants = $participants->map(function($p) {
            $assignments = $p->user->assignments;
            $isEndDatePassed = $p->end_date && now()->isAfter($p->end_date);
            $allAssignmentsGraded = $assignments->count() > 0 && $assignments->every(fn($a) => $a->grade !== null);
            
            // Status selesai hanya jika end_date sudah lewat
            $p->is_completed = $isEndDatePassed;
            $p->all_assignments_graded = $allAssignmentsGraded;
            return $p;
        });
        
        return view('mentor.sertifikat', [
            'participants' => $participants
        ]);
    }

    public function profil()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $subdirektorat = $divisi ? $divisi->subDirektorat : null;
        $direktorat = $subdirektorat ? $subdirektorat->direktorat : null;
        return view('mentor.profil', [
            'user' => $user,
            'divisi' => $divisi,
            'subdirektorat' => $subdirektorat,
            'direktorat' => $direktorat
        ]);
    }

    public function responPengajuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,postponed',
            'notes' => 'required_if:status,rejected,postponed',
        ], [
            'notes.required_if' => 'Alasan wajib diisi untuk penolakan atau penundaan.'
        ]);

        $application = \App\Models\InternshipApplication::findOrFail($id);
        // Pastikan hanya pembimbing divisi terkait yang bisa merespon
        if (Auth::user()->divisi_id !== $application->divisi_id) {
            abort(403);
        }
        $application->status = $request->status;
        $application->notes = $request->status === 'accepted' ? null : $request->notes;
        $application->save();

        // Set divisi_id user jika diterima
        if ($request->status === 'accepted') {
            $application->user->divisi_id = $application->divisi_id;
            $application->user->save();
        }

        return redirect()->route('mentor.pengajuan')->with('success', 'Respon pengajuan berhasil disimpan.');
    }

    public function tambahPenugasan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,zip|max:4096',
            'online_text' => 'nullable|string',
        ]);
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'online_text' => $request->online_text,
        ];
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('assignments', 'public');
        }
        \App\Models\Assignment::create($data);
        return redirect()->route('mentor.penugasan')->with('success', 'Penugasan berhasil ditambahkan.');
    }

    public function beriNilaiPenugasan(Request $request, $assignmentId)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);
        $assignment = \App\Models\Assignment::findOrFail($assignmentId);
        // Pastikan hanya pembimbing divisi terkait yang bisa menilai
        $user = Auth::user();
        if (!$assignment->user || $assignment->user->divisi_id !== $user->divisi_id) {
            abort(403);
        }
        $assignment->grade = $request->grade;
        $assignment->save();
        return redirect()->route('mentor.penugasan')->with('success', 'Nilai tugas berhasil disimpan.');
    }

    public function uploadSertifikat(Request $request, $userId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:4096',
        ]);
        $user = \App\Models\User::findOrFail($userId);
        // Simpan file
        $path = $request->file('certificate')->store('certificates', 'public');
        // Update/insert certificate
        $certificate = $user->certificates->first();
        if ($certificate) {
            $certificate->certificate_path = $path;
            $certificate->issued_at = now();
            $certificate->save();
        } else {
            $user->certificates()->create([
                'certificate_path' => $path,
                'issued_at' => now(),
            ]);
        }
        return redirect()->route('mentor.sertifikat')->with('success', 'Sertifikat berhasil diupload.');
    }
} 