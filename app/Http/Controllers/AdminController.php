<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Direktorat;
use App\Models\SubDirektorat;
use App\Models\Divisi;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalParticipants = User::where('role', 'peserta')
            ->whereHas('internshipApplications', function($q) {
                $q->where('status', 'accepted');
            })
            ->count();
        $totalApplications = InternshipApplication::count();
        $totalFinishedParticipants = InternshipApplication::where('status', 'finished')->count();
        $recentApplications = InternshipApplication::with(['user', 'divisi'])
            ->latest()
            ->take(10)
            ->get();
        $divisions = Divisi::withCount(['internshipApplications' => function($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }])->get();
        return view('admin.dashboard', compact('totalParticipants', 'totalApplications', 'totalFinishedParticipants', 'recentApplications', 'divisions'));
    }

    public function applications()
    {
        $applications = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->latest()->get();
        return view('admin.applications', compact('applications'));
    }

    public function participants()
    {
        $participants = User::where('role', 'peserta')
            ->with(['internshipApplications.divisi', 'certificates', 'assignments'])
            ->get();
        return view('admin.participants', compact('participants'));
    }

    public function divisions()
    {
        $direktorats = Direktorat::with('subDirektorats.divisis')->get();
        return view('admin.divisions', compact('direktorats'));
    }

    public function mentors()
    {
        $mentors = User::where('role', 'pembimbing')
            ->whereNotNull('divisi_id')
            ->with([
                'divisi.subDirektorat.direktorat',
                'divisi.internshipApplications.user.certificates',
                'divisi.internshipApplications.user.assignments',
            ])
            ->get()
            ->filter(function($mentor) {
                return $mentor->divisi !== null;
            });

        return view('admin.mentors', compact('mentors'));
    }

    // Direktorat CRUD Methods
    public function storeDirektorat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name'
        ]);

        Direktorat::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateDirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name,' . $id
        ]);

        $direktorat = Direktorat::findOrFail($id);
        $direktorat->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDirektorat($id)
    {
        $direktorat = Direktorat::findOrFail($id);
        
        // Check if direktorat has subdirektorats
        if ($direktorat->subDirektorats()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Direktorat "' . $direktorat->name . '" karena masih memiliki subdirektorat');
        }
        
        $direktoratName = $direktorat->name;
        $direktorat->delete();

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $direktoratName . '" berhasil dihapus');
    }

    // SubDirektorat CRUD Methods
    public function storeSubdirektorat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'direktorat_id' => 'required|exists:direktorats,id'
        ]);

        SubDirektorat::create([
            'name' => $request->name,
            'direktorat_id' => $request->direktorat_id
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateSubdirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'direktorat_id' => 'required|exists:direktorats,id'
        ]);

        $subdirektorat = SubDirektorat::findOrFail($id);
        $subdirektorat->update([
            'name' => $request->name,
            'direktorat_id' => $request->direktorat_id
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteSubdirektorat($id)
    {
        $subdirektorat = SubDirektorat::findOrFail($id);
        
        // Check if subdirektorat has divisis
        if ($subdirektorat->divisis()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Subdirektorat "' . $subdirektorat->name . '" karena masih memiliki divisi');
        }
        
        $subdirektoratName = $subdirektorat->name;
        $subdirektorat->delete();

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $subdirektoratName . '" berhasil dihapus');
    }

    // Divisi CRUD Methods
    public function storeDivisi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_direktorat_id' => 'required|exists:sub_direktorats,id',
            'pic_name' => 'required|string|max:255',
            'nippos' => 'required|string|max:255'
        ]);

        // Create the divisi
        $divisi = Divisi::create([
            'name' => $request->name,
            'sub_direktorat_id' => $request->sub_direktorat_id,
            'pic_name' => $request->pic_name,
            'nippos' => $request->nippos
        ]);

        // Create user pembimbing for this divisi
        $username = 'mentor_' . strtolower(str_replace(' ', '_', $request->name));
        $email = $username . '@posindonesia.co.id';
        
        // Check if username already exists, if so, add number
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '_' . $counter;
            $email = $username . '@posindonesia.co.id';
            $counter++;
        }

        User::create([
            'username' => $username,
            'name' => $request->pic_name,
            'email' => $email,
            'password' => bcrypt('mentor123'),
            'role' => 'pembimbing',
            'divisi_id' => $divisi->id
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $request->name . '" berhasil ditambahkan dan user pembimbing telah dibuat dengan username: ' . $username);
    }

    public function updateDivisi(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_direktorat_id' => 'required|exists:sub_direktorats,id',
            'pic_name' => 'required|string|max:255',
            'nippos' => 'required|string|max:255'
        ]);

        $divisi = Divisi::findOrFail($id);
        $oldPicName = $divisi->pic_name;
        
        $divisi->update([
            'name' => $request->name,
            'sub_direktorat_id' => $request->sub_direktorat_id,
            'pic_name' => $request->pic_name,
            'nippos' => $request->nippos
        ]);

        // Update pembimbing user if PIC name changed
        if ($oldPicName !== $request->pic_name) {
            $pembimbing = User::where('divisi_id', $divisi->id)
                             ->where('role', 'pembimbing')
                             ->first();
            
            if ($pembimbing) {
                $pembimbing->update([
                    'name' => $request->pic_name
                ]);
            }
        }

        return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        
        // Check if divisi has internship applications
        if ($divisi->internshipApplications()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Divisi "' . $divisi->name . '" karena masih memiliki pengajuan magang');
        }
        
        // Delete pembimbing user for this divisi
        $pembimbing = User::where('divisi_id', $divisi->id)
                         ->where('role', 'pembimbing')
                         ->first();
        
        $divisiName = $divisi->name;
        $pembimbingName = $pembimbing ? $pembimbing->name : null;
        
        if ($pembimbing) {
            $pembimbing->delete();
        }
        
        $divisi->delete();

        if ($pembimbing) {
            return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $divisiName . '" dan user pembimbing "' . $pembimbingName . '" berhasil dihapus');
        } else {
            return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $divisiName . '" berhasil dihapus');
        }
    }

    public function resetMentorPassword($id)
    {
        $mentor = User::where('id', $id)
                     ->where('role', 'pembimbing')
                     ->firstOrFail();
        
        $mentor->update([
            'password' => Hash::make('mentor123')
        ]);

        return redirect()->route('admin.mentors')->with('success', 'Password pembimbing ' . $mentor->name . ' berhasil direset menjadi "mentor123"');
    }
} 