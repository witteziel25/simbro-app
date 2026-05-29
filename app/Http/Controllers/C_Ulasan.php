<?php

namespace App\Http\Controllers;

use App\Models\M_Ulasan;
use App\Models\M_Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Ulasan extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required|exists:transaksi,transaksi_id',
            'rating'       => 'required|integer|min:1|max:5',
            'ulasan'       => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Harap isi data ulasan dengan lengkap'], 422);
        }

        // Cek kepemilikan dan status transaksi
        $transaksi = M_Transaksi::where('user_id', session('user_id'))
            ->where('transaksi_id', $request->transaksi_id)
            ->with('status')
            ->first();

        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaksi->status->nama_status !== 'diterima') {
            return response()->json(['success' => false, 'message' => 'Ulasan hanya bisa diberikan untuk transaksi dengan status diterima'], 403);
        }

        // Cegah duplikasi ulasan
        $existing = M_Ulasan::where('transaksi_id', $request->transaksi_id)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Ulasan sudah ada, silakan hapus jika ingin mengubah'], 422);
        }

        $ulasan = M_Ulasan::create([
            'user_id'       => session('user_id'),
            'transaksi_id'  => $request->transaksi_id,
            'rating'        => $request->rating,
            'ulasan'        => $request->ulasan,
        ]);

        return response()->json(['success' => true, 'message' => 'Ulasan terkirim', 'data' => $ulasan]);
    }

    public function destroy($id)
    {
        $ulasan = M_Ulasan::where('ulasan_id', $id)
            ->whereHas('transaksi', function($q) {
                $q->where('user_id', session('user_id'));
            })
            ->first();

        if (!$ulasan) {
            return response()->json(['success' => false, 'message' => 'Ulasan tidak ditemukan'], 404);
        }

        $ulasan->delete();
        return response()->json(['success' => true, 'message' => 'Ulasan berhasil dihapus']);
    }
}
