<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class C_Authentication extends Controller
{
    // FORM LOGIN & REGISTER
    public function showFormLogin()
    {
        return view('V_Login');
    }

    public function showFormRegister()
    {
        return view('V_Register');
    }

    // PROSES LOGIN
    public function klikLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = M_User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
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
            return back()->withErrors(['login' => 'Data tidak sesuai, harap isi kembali'])->withInput();
        }
    }

    // PROSES REGISTER
    public function klikRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:m_users,email',
            'no_hp' => 'required|digits_between:10,13',
            'alamat' => 'required',
            'username' => 'required|unique:m_users,username',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'nama_lengkap.required' => 'Harap isi data dengan lengkap',
            'email.required' => 'Harap isi data dengan lengkap',
            'email.email' => 'Data tidak sesuai, harap isi kembali',
            'email.unique' => 'Data tidak sesuai, harap isi kembali',
            'no_hp.required' => 'Harap isi data dengan lengkap',
            'no_hp.digits_between' => 'Data tidak sesuai, harap isi kembali',
            'alamat.required' => 'Harap isi data dengan lengkap',
            'username.required' => 'Harap isi data dengan lengkap',
            'username.unique' => 'Data tidak sesuai, harap isi kembali',
            'password.required' => 'Harap isi data dengan lengkap',
            'password.min' => 'Data tidak sesuai, harap isi kembali',
            'password_confirmation.required' => 'Harap isi data dengan lengkap',
            'password_confirmation.same' => 'Data tidak sesuai, harap isi kembali',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        M_User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login.');
    }

    // LOGOUT
    public function klikLogout()
    {
        session()->flush();
        return redirect()->route('landing')->with('success', 'Anda telah logout.');
    }

    // HALAMAN HOME
    public function showHome()
    {
        $produk = \App\Models\M_Produk::all();

        if (session('role') == 1) {
            return view('admin.V_Home', compact('produk'));
        } else {
            return view('customer.V_Home', compact('produk'));
        }
    }

    // LUPA PASSWORD - OTP - RESET
    public function showForgotForm()
    {
        return view('V_ForgotPassword');
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:m_users,username'
        ], [
            'username.required' => 'Username wajib diisi',
            'username.exists' => 'Data tidak sesuai, harap isi kembali'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
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
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
        ]);

        if (!session('otp_code')) {
            return redirect()->route('password.request')->withErrors('Sesi tidak ditemukan. Silakan minta OTP ulang.');
        }
        if (session('otp_expires') < Carbon::now()->timestamp) {
            session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')->withErrors('Kode OTP telah kadaluwarsa. Silakan minta ulang.');
        }

        $enteredOtp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        if ($enteredOtp == session('otp_code')) {
            session(['otp_verified' => true]);
            session()->save();
            return redirect()->route('password.reset')->with('success', 'Data Sesuai');
        } else {
            return back()->withErrors(['otp' => 'Data tidak sesuai, harap isi kembali']);
        }
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
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Data tidak sesuai, harap isi kembali',
            'password.confirmed' => 'Data tidak sesuai, harap isi kembali',
        ]);

        $user = M_User::where('email', session('otp_email'))->first();
        if (!$user) {
            return redirect()->route('login')->withErrors('Terjadi kesalahan. Silakan ulangi proses lupa password.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password baru telah disimpan. Silakan login.');
    }
}
