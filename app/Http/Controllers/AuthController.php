<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InternshipApplication;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else if (Auth::user()->role === 'pembimbing') {
                return redirect()->intended('/mentor/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Display the registration form.
     */
    public function showRegister()
    {
        $divisis = Divisi::with('subDirektorat.direktorat')->get();
        return view('auth.register', compact('divisis'));
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed|different:username',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required',
            'university' => 'required',
            'major' => 'required',
            'phone' => 'required',
            'ktp_number' => 'required',
            'divisi_id' => 'required|exists:divisis,id',
            'cover_letter' => 'required|file|mimes:pdf|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'password.different' => 'Password tidak boleh sama dengan username.'
        ]);

        // Create user
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'university' => $request->university,
            'major' => $request->major,
            'phone' => $request->phone,
            'ktp_number' => $request->ktp_number,
            'role' => 'peserta',
        ]);

        // Handle file upload
        if ($request->hasFile('cover_letter')) {
            $path = $request->file('cover_letter')->store('cover_letters', 'public');
        }

        // Create internship application
        InternshipApplication::create([
            'user_id' => $user->id,
            'divisi_id' => $request->divisi_id,
            'status' => 'pending',
            'cover_letter_path' => $path ?? null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Auto login after registration
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Pengajuan magang Anda telah dikirim.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the form for changing password.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed|different:current_password',
        ], [
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.'
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
