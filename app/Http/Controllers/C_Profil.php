<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_Profil extends Controller
{
    // Customer: Tampilkan halaman profil
    public function showCustomerProfil()
    {
        if (!session('user_logged_in') || session('role') != 0) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }
        $user = (object) [
            'user_id' => session('user_id'),
            'nama_lengkap' => session('nama_lengkap'),
            'username' => session('username'),
            'email' => session('email'),
            'no_hp' => session('no_hp'),
            'alamat' => session('alamat'),
            'peran' => session('peran'),
        ];
        return view('customer.V_Profil', compact('user'));
    }

    // Customer: Update profil (AJAX)
    public function klikUpdateCustomerProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:m_users,username,' . session('user_id') . ',user_id',
            'email'        => 'required|email|max:255|unique:m_users,email,' . session('user_id') . ',user_id',
            'no_hp'        => 'required|digits_between:10,13',
            'alamat'       => 'required|string',
            'peran'        => 'required|in:peternak,rumah_pemotongan',
            'password'     => 'nullable|min:8',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan, silakan pilih yang lain.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'no_hp.required'        => 'Nomor telepon wajib diisi.',
            'no_hp.digits_between'  => 'Nomor telepon harus terdiri dari 10-13 digit.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'peran.required'        => 'Peran wajib dipilih.',
            'password.min'          => 'Password minimal terdiri dari 8 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = M_User::find(session('user_id'));
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username     = $request->username;
        $user->email        = $request->email;
        $user->no_hp        = $request->no_hp;
        $user->alamat       = $request->alamat;
        $user->peran        = $request->peran;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update session
        session([
            'nama_lengkap' => $user->nama_lengkap,
            'username'     => $user->username,
            'email'        => $user->email,
            'no_hp'        => $user->no_hp,
            'alamat'       => $user->alamat,
            'peran'        => $user->peran,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    // Admin: Tampilkan halaman profil
    public function showAdminProfil()
    {
        if (!session('user_logged_in') || session('role') != 1) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }
        $user = (object) [
            'user_id'  => session('user_id'),
            'username' => session('username'),
            'email'    => session('email'),
        ];
        return view('admin.V_Profil', compact('user'));
    }

    // Admin: Update profil (AJAX)
    public function klikUpdateAdminProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:m_users,username,' . session('user_id') . ',user_id',
            'email'    => 'required|email|max:255|unique:m_users,email,' . session('user_id') . ',user_id',
            'password' => 'nullable|min:8',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan, silakan pilih yang lain.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal terdiri dari 8 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = M_User::find(session('user_id'));
        $user->username = $request->username;
        $user->email    = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update session
        session([
            'username' => $user->username,
            'email'    => $user->email,
        ]);

        return response()->json(['success' => true, 'message' => 'Data admin berhasil diperbarui.']);
    }

    // Admin: Tampilkan daftar semua customer
    public function showDataCustomer()
    {
        if (!session('user_logged_in') || session('role') != 1) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }
        $customers = M_User::where('role', 0)->get();
        return view('admin.V_DataCustomer', compact('customers'));
    }
}
