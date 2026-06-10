<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_Profil extends Controller
{
    // --- Customer Profil ---
    public function showCustomerProfil()
    {
        $user = (object) [
            'user_id'      => session('user_id'),
            'nama_lengkap' => session('nama_lengkap'),
            'username'     => session('username'),
            'email'        => session('email'),
            'no_hp'        => session('no_hp'),
            'alamat'       => session('alamat'),
        ];
        return view('customer.V_Profil', compact('user'));
    }
    // --- Update Profil Customer ---
    public function klikUpdateCustomerProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:m_users,username,' . session('user_id') . ',user_id',
            'email'        => 'required|email|max:255|unique:m_users,email,' . session('user_id') . ',user_id',
            'no_hp'        => 'required|digits_between:10,13',
            'alamat'       => 'required|string',
            'password'     => 'nullable|min:8',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'username.required'     => 'Username harus diisi',
            'username.unique'       => 'Username sudah digunakan',
            'email.required'        => 'Email harus diisi',
            'email.email'           => 'Email harus mengandung domain (contoh: nama@domain.com)',
            'email.unique'          => 'Email sudah digunakan',
            'no_hp.required'        => 'Nomor HP harus diisi',
            'no_hp.digits_between'  => 'Nomor HP harus terdiri dari 10-13 digit',
            'alamat.required'       => 'Alamat harus diisi',
            'password.min'          => 'Password harus memuat minimal 8 karakter',
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

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        session([
            'nama_lengkap' => $user->nama_lengkap,
            'username'     => $user->username,
            'email'        => $user->email,
            'no_hp'        => $user->no_hp,
            'alamat'       => $user->alamat,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }
    // --- Admin Profil ---
    public function showAdminProfil()
    {
        $user = (object) [
            'user_id'  => session('user_id'),
            'username' => session('username'),
            'email'    => session('email'),
        ];
        return view('admin.V_Profil', compact('user'));
    }
    // --- Update Profil Admin ---
    public function klikUpdateAdminProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:m_users,username,' . session('user_id') . ',user_id',
            'email'    => 'required|email|max:255|unique:m_users,email,' . session('user_id') . ',user_id',
            'password' => 'nullable|min:8',
        ], [
            'username.required' => 'Username harus diisi',
            'username.unique'   => 'Username sudah digunakan',
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Email harus mengandung domain (contoh: nama@domain.com)',
            'email.unique'      => 'Email sudah digunakan',
            'password.min'      => 'Password harus memuat minimal 8 karakter',
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

        session([
            'username' => $user->username,
            'email'    => $user->email,
        ]);

        return response()->json(['success' => true, 'message' => 'Data admin berhasil diperbarui.']);
    }
    // --- Data Customer (Admin) ---
    public function showDataCustomer()
    {
        $customers = M_User::where('role', 0)->get();
        return view('admin.V_DataCustomer', compact('customers'));
    }
}
