<?php

namespace App\Http\Controllers;

use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class C_Authentication extends Controller
{
    public function showFormLogin()
    {
        return view('V_Login');
    }

    public function showFormRegister()
    {
        return view('V_Register');
    }

    public function klikLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Harap isi data dengan lengkap',
            'password.required' => 'Harap isi data dengan lengkap'
        ]);

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
                'alamat' => $user->alamat
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

    public function klikRegister(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:m_users,email',
            'no_hp' => 'required',
            'alamat' => 'required',
            'username' => 'required|unique:m_users,username',
            'password' => 'required|min:8'
        ], [
            'nama_lengkap.required' => 'Harap isi data dengan lengkap',
            'email.required' => 'Harap isi data dengan lengkap',
            'no_hp.required' => 'Harap isi data dengan lengkap',
            'alamat.required' => 'Harap isi data dengan lengkap',
            'username.required' => 'Harap isi data dengan lengkap',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Harap isi data dengan lengkap',
            'password.min' => 'Password minimal 8 digit'
        ]);

        M_User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 0 // customer
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login.');
    }

    public function klikLogout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout telah berhasil');
    }

    public function showFormOTP()
    {
        $otp = rand(1000, 9999);
        session(['otp_code' => $otp, 'otp_verified' => false]);
        return view('V_OTP')->with('info', "Kode OTP Anda: $otp (simulasi)");
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
        ]);

        $enteredOtp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        if ($enteredOtp == session('otp_code')) {
            session(['otp_verified' => true]);
            return redirect()->route('password.reset')->with('success', 'Data Sesuai');
        } else {
            return back()->withErrors(['otp' => 'Data tidak sesuai. Mohon isi kembali']);
        }
    }

    public function showFormReset()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.otp')->withErrors('Harap verifikasi OTP terlebih dahulu.');
        }
        return view('V_ResetPassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 digit',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok'
        ]);

        session()->forget(['otp_code', 'otp_verified']);
        return redirect()->route('customer.home')->with('success', 'Password baru telah disimpan');
    }

    public function showCustomerHome()
    {
        if (session('role') != 0) return redirect()->route('login');
        return view('customer.V_Home');
    }

    public function showAdminHome()
    {
        if (session('role') != 1) return redirect()->route('login');
        return view('admin.V_Home');
    }
}
