<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_User;
use Illuminate\Support\Facades\Hash;

class C_Profil extends Controller
{
    public function showCustomerProfil()
    {
        if (session('role') != 0) return redirect()->route('login');
        $user = (object) [
            'user_id' => session('user_id'),
            'nama_lengkap' => session('nama_lengkap'),
            'username' => session('username'),
            'email' => session('email'),
            'no_hp' => session('no_hp'),
            'alamat' => session('alamat'),
        ];
        return view('customer.V_Profil', compact('user'));
    }

    public function klikUpdateCustomerProfil(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $user = M_User::find(session('user_id'));
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        session([
            'nama_lengkap' => $user->nama_lengkap,
            'username' => $user->username,
            'email' => $user->email,
            'no_hp' => $user->no_hp,
            'alamat' => $user->alamat,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }

    public function showAdminProfil()
    {
        if (session('role') != 1) return redirect()->route('login');
        $user = (object) [
            'user_id' => session('user_id'),
            'username' => session('username'),
            'email' => session('email'),
        ];
        return view('admin.V_Profil', compact('user'));
    }

    public function klikUpdateAdminProfil(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);

        $user = M_User::find(session('user_id'));
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        session([
            'username' => $user->username,
            'email' => $user->email,
        ]);

        return response()->json(['success' => true, 'message' => 'Data admin berhasil diperbarui']);
    }

    public function showDataCustomer()
    {
        // Pastikan yang mengakses adalah admin
        if (session('role') != 1) {
            return redirect()->route('login');
        }
        // Ambil semua user dengan role = 0 (customer)
        $customers = M_User::where('role', 0)->get();
        return view('admin.V_DataCustomer', compact('customers'));
    }
}
