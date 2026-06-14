<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use App\Models\M_Ulasan;
use App\Models\M_Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class C_Authentication extends Controller
{
    // --- Form Login & Register ---
    public function showFormLogin()
    {
        return view('V_Login');
    }

    public function showFormRegister()
    {
        return view('V_Register');
    }
    // --- Proses Login ---
    public function klikLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = M_User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->role == 0 && !$user->is_active) {
                return redirect()->route('customer.disabled')->with('nama_lengkap', $user->nama_lengkap);
            }

            session([
                'user_logged_in' => true,
                'user_id' => $user->user_id,
                'username' => $user->username,
                'role' => $user->role,
                'nama_lengkap' => $user->nama_lengkap,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat,
            ]);

            if ($user->role == 1) {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('customer.home');
            }
        } else {
            $errors = [];
            if (!$user) {
                $errors['username'] = ['Username tidak ditemukan'];
            } else {
                $errors['password'] = ['Password salah'];
            }
            return back()->withErrors($errors)->withInput();
        }
    }
    // --- Proses Register ---
    public function klikRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|email|unique:m_users,email',
        'no_hp' => 'required|digits_between:10,13',
        'alamat' => 'required|string',
        'username' => 'required|string|max:255|unique:m_users,username',
        'password' => 'required|min:8',
        'password_confirmation' => 'required|same:password',
    ], [
        'nama_lengkap.required' => 'Nama lengkap harus diisi',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Email harus memuat domain (contoh: nama@domain.com)',
        'email.unique' => 'Email sudah terdaftar',
        'no_hp.required' => 'Nomor telepon harus diisi',
        'no_hp.digits_between' => 'Nomor telepon harus terdiri dari 10-13 digit',
        'alamat.required' => 'Alamat harus diisi',
        'username.required' => 'Username harus diisi',
        'username.unique' => 'Username sudah digunakan',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password harus terdiri minimal 8 karakter',
        'password_confirmation.required' => 'Konfirmasi password harus diisi',
        'password_confirmation.same' => 'Password yang dikonfirmasi tidak sesuai',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

        M_User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login');
    }
    // --- Logout ---
    public function klikLogout()
    {
        session()->flush();
        return redirect()->route('landing')->with('success', 'Anda telah logout');
    }
    // --- Halaman Home ---
    public function showHome()
    {
        $produk = \App\Models\M_Produk::all();
        $ulasan = \App\Models\M_Ulasan::with(['user', 'transaksi.details.produk'])->orderBy('created_at', 'desc')->get();
        $slides = M_Gallery::orderBy('created_at', 'desc')->get(); // ← pastikan selalu collection

        if (session('role') == 1) {
            return view('admin.V_Home', compact('produk', 'ulasan', 'slides'));
        } else {
            return view('customer.V_Home', compact('produk', 'ulasan', 'slides'));
        }
    }
    // --- Lupa Password - OTP - Reset ---
    public function showForgotForm()
    {
        return view('V_ForgotPassword');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:m_users,username'
        ], [
            'username.required' => 'Username harus diisi',
            'username.exists' => 'Username tidak ditemukan'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = M_User::where('username', $request->username)->first();
        $otp = rand(1000, 9999);

        session([
            'otp_code' => $otp,
            'otp_email' => $user->email,
            'otp_expires' => Carbon::now()->addMinutes(15)->timestamp,
            'otp_verified' => false
        ]);
        session()->save();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, $user->nama_lengkap));
            return redirect()->route('password.otp')->with('info', "Kode OTP telah dikirim ke email $user->email");
        } catch (\Exception $e) {
            return redirect()->route('password.otp')->with('error', 'Gagal mengirim email. Kode OTP: ' . $otp);
        }
    }

    public function showOtpForm()
    {
        if (!session('otp_code')) {
            return redirect()->route('password.request')->withErrors('Sesi tidak ditemukan. Silakan minta OTP ulang.');
        }
        if (session('otp_expires') < Carbon::now()->timestamp) {
            session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')->withErrors('Sesi OTP telah kadaluwarsa. Silakan minta ulang.');
        }
        return view('V_OTP');
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
        ], [
            'otp1.required' => 'Kode OTP harus diisi',
            'otp2.required' => 'Kode OTP harus diisi',
            'otp3.required' => 'Kode OTP harus diisi',
            'otp4.required' => 'Kode OTP harus diisi',
            'otp1.numeric' => 'OTP harus berupa angka',
            'otp2.numeric' => 'OTP harus berupa angka',
            'otp3.numeric' => 'OTP harus berupa angka',
            'otp4.numeric' => 'OTP harus berupa angka',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['otp' => 'Kode OTP harus diisi'])->withInput();
        }

        if (!session('otp_code')) {
            return redirect()->route('password.request')->withErrors(['otp' => 'Sesi tidak ditemukan'])->withInput();
        }
        if (session('otp_expires') < Carbon::now()->timestamp) {
            session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')->withErrors(['otp' => 'Kode OTP telah kadaluwarsa'])->withInput();
        }

        $enteredOtp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        if ($enteredOtp != session('otp_code')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai'])->withInput();
        }

        session(['otp_verified' => true]);
        session()->save();
        return redirect()->route('password.reset')->with('success', 'Data Sesuai');
    }

    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors('Harap verifikasi OTP terlebih dahulu.');
        }
        if (session('otp_expires') < Carbon::now()->timestamp) {
            session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')->withErrors('Sesi OTP telah kadaluwarsa.');
        }
        return view('V_ResetPassword');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus terdiri minimal 8 karakter',
            'password.confirmed' => 'Password yang dikonfirmasi tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = M_User::where('email', session('otp_email'))->first();
        if (!$user) {
            return redirect()->route('login')->withErrors('Terjadi kesalahan. Silakan ulangi proses lupa password.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password baru telah disimpan. Silakan login');
    }
}
