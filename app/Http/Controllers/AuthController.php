<?php

namespace App\Http\Controllers;

use App\Models\Talent;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->role === 'admin_pemko') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = 'Akun administrator harus masuk melalui tautan login khusus admin.';

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                    ], 403);
                }

                return back()->withErrors(['email' => $message])->onlyInput('email');
            }

            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Selamat datang kembali, '.$user->name,
                    'redirect' => redirect()->intended('/')->getTargetUrl(),
                ]);
            }

            return redirect()->intended('/')->with('success', 'Selamat datang kembali, '.$user->name.'!');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, false)) {
            $user = Auth::user();

            if ($user->role !== 'admin_pemko') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki hak akses administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang di Panel Admin KITAME, '.$user->name.'.');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi administrator tidak sesuai.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:umkm,talent',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'role.required' => 'Pilih jenis akun pendaftaran Anda.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'is_verified' => false,
        ]);

        if ($request->role === 'umkm') {
            Umkm::create([
                'user_id' => $user->id,
                'nib' => null,
                'business_name' => $user->name,
                'category' => 'Kuliner Tradisional',
                'kecamatan' => 'Medan Petisah',
                'address' => 'Kota Medan, Sumatera Utara',
                'description' => 'Pelaku usaha UMKM terdaftar di KITAME Kota Medan.',
                'e_catalog_pemko' => false,
                'whatsapp' => $user->phone,
                'email' => $user->email,
            ]);
        } elseif ($request->role === 'talent') {
            Talent::create([
                'user_id' => $user->id,
                'nik' => null,
                'category' => 'Programmer & IT',
                'kecamatan' => 'Medan Selayang',
                'expertise' => 'Belum diisi',
                'portfolio_url' => null,
                'disnaker_certified' => false,
                'bio' => 'Talenta kreatif terdaftar di Medan Talent Hub.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran akun berhasil!',
                'redirect' => url()->previous(),
            ]);
        }

        return back()->with('success', 'Akun berhasil didaftarkan! Selamat datang di Portal KITAME, '.$user->name.'.');
    }

    public function logout(Request $request)
    {
        $wasAdmin = $request->user()?->role === 'admin_pemko';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari portal admin.');
        }

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }

    public function requestPasswordReset()
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Jika email terdaftar, tautan untuk mengatur ulang kata sandi akan dikirim.');
    }

    public function showPasswordReset(string $token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $data,
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => $data['password'],
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.')
            : back()->withInput($request->only('email'))->with('error', 'Tautan reset kata sandi tidak valid atau sudah kedaluwarsa.');
    }
}