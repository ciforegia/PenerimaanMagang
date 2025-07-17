<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $pendingApplications = $divisi
            ? $divisi->internshipApplications()->where('status', 'pending')->count()
            : 0;
        $activeParticipants = $divisi
            ? $divisi->internshipApplications()
                ->where('status', 'accepted')
                ->where(function($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->count()
            : 0;
        $assignmentsToGrade = $divisi
            ? \App\Models\Assignment::whereHas('user.internshipApplications', function($q) use ($divisi) {
                $q->where('divisi_id', $divisi->id)->where('status', 'accepted');
            })->whereNotNull('submission_file_path')->whereNull('grade')->count()
            : 0;
        $pengajuanBaru = $divisi
            ? $divisi->internshipApplications()->where('status', 'pending')->count()
            : 0;
        $tugasBaruDiupload = $divisi
            ? \App\Models\Assignment::whereHas('user.internshipApplications', function($q) use ($divisi) {
                $q->where('divisi_id', $divisi->id)->where('status', 'accepted');
            })->whereNotNull('submission_file_path')->whereNull('grade')->count()
            : 0;
        return view('mentor.dashboard', [
            'pendingApplications' => $pendingApplications,
            'activeParticipants' => $activeParticipants,
            'assignmentsToGrade' => $assignmentsToGrade,
            'pengajuanBaru' => $pengajuanBaru,
            'tugasBaruDiupload' => $tugasBaruDiupload,
        ]);
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
            $noRevision = $assignments->count() > 0 && $assignments->every(fn($a) => $a->is_revision !== 1);
            // Syarat upload: semua tugas dinilai/feedback dan tidak ada tugas status revisi
            $p->can_upload_certificate = $allAssignmentsGraded && $noRevision;
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
        $assignment = \App\Models\Assignment::findOrFail($assignmentId);
        $user = Auth::user();
        if (!$assignment->user || $assignment->user->divisi_id !== $user->divisi_id) {
            abort(403);
        }
        // Jika revisi diizinkan, hanya feedback yang bisa diinput
        if ($assignment->is_revision === 1) {
            $request->validate([
                'feedback' => 'required|string',
            ]);
            $assignment->feedback = $request->feedback;
            // Nilai tidak diubah
        } else {
            $request->validate([
                'grade' => 'required|numeric|min:0|max:100',
                'feedback' => 'nullable|string',
            ]);
            $assignment->grade = $request->grade;
            $assignment->feedback = $request->feedback;
        }
        $assignment->save();
        return redirect()->route('mentor.penugasan')
            ->with('success', 'Penilaian tugas berhasil disimpan.')
            ->with('feedback_saved_assignment_id', $assignment->id);
    }

    public function setRevisiPenugasan(Request $request, $assignmentId)
    {
        $request->validate([
            'is_revision' => 'required|in:0,1',
        ]);
        $assignment = \App\Models\Assignment::findOrFail($assignmentId);
        $user = Auth::user();
        if (!$assignment->user || $assignment->user->divisi_id !== $user->divisi_id) {
            abort(403);
        }
        $assignment->is_revision = $request->is_revision;
        $assignment->save();
        return redirect()->route('mentor.penugasan')->with('success', 'Status revisi tugas berhasil diperbarui.');
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