<?php

namespace App\Http\Controllers;

use App\Models\M_Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class C_Produk extends Controller
{
    // --- Form Tambah ---
    public function showFormTambahDataProduk()
    {
        return view('produk.V_Tambah');
    }
    // --- Proses Tambah ---
    public function tambahProduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'required|in:Bibit Ayam Broiler,Ayam Broiler Dewasa',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama_produk.required' => 'Harap isi data dengan lengkap',
            'deskripsi.required'   => 'Harap isi data dengan lengkap',
            'harga.required'       => 'Harap isi data dengan lengkap',
            'harga.numeric'        => 'Data tidak sesuai, silahkan isi kembali',
            'harga.min'            => 'Data tidak sesuai, silahkan isi kembali',
            'stok.required'        => 'Harap isi data dengan lengkap',
            'stok.integer'         => 'Data tidak sesuai, silahkan isi kembali',
            'stok.min'             => 'Data tidak sesuai, silahkan isi kembali',
            'kategori.required'    => 'Harap isi data dengan lengkap',
            'kategori.in'          => 'Data tidak sesuai, silahkan isi kembali',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('lightbox_message', $validator->errors()->first())->with('lightbox_type', 'error');
        }

        $data = $request->except('_token', 'foto');
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('produk', 'public');
            $data['foto'] = $path;
        }

        M_Produk::create($data);

        return redirect()->to(route('admin.home') . '#produk')->with('lightbox_message', 'Produk berhasil ditambahkan.')->with('lightbox_type', 'success');
    }
    // --- Form Ubah ---
    public function showFormUbahDataProduk($id)
    {
        $produk = M_Produk::findOrFail($id);
        return view('produk.V_Ubah', compact('produk'));
    }
    // --- Proses Ubah ---
    public function simpan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'required|in:Bibit Ayam Broiler,Ayam Broiler Dewasa',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama_produk.required' => 'Harap isi data dengan lengkap',
            'deskripsi.required'   => 'Harap isi data dengan lengkap',
            'harga.required'       => 'Harap isi data dengan lengkap',
            'harga.numeric'        => 'Data tidak sesuai, silahkan isi kembali',
            'harga.min'            => 'Data tidak sesuai, silahkan isi kembali',
            'stok.required'        => 'Harap isi data dengan lengkap',
            'stok.integer'         => 'Data tidak sesuai, silahkan isi kembali',
            'stok.min'             => 'Data tidak sesuai, silahkan isi kembali',
            'kategori.required'    => 'Harap isi data dengan lengkap',
            'kategori.in'          => 'Data tidak sesuai, silahkan isi kembali',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('lightbox_message', $validator->errors()->first())->with('lightbox_type', 'error');
        }

        $produk = M_Produk::findOrFail($id);
        $data = $request->except('_token', 'foto', '_method');
        if ($request->hasFile('foto')) {
            if ($produk->foto) Storage::disk('public')->delete($produk->foto);
            $path = $request->file('foto')->store('produk', 'public');
            $data['foto'] = $path;
        }
        $produk->update($data);

        return redirect()->to(route('admin.home') . '#produk')->with('lightbox_message', 'Produk berhasil diubah.')->with('lightbox_type', 'success');
    }
    // --- Hapus Produk (soft delete) ---
    public function hapus($id)
    {
        $produk = M_Produk::findOrFail($id);
        $produk->delete();

        return redirect()->to(route('admin.home') . '#produk')->with('lightbox_message', 'Produk dipindahkan ke tempat sampah.')->with('lightbox_type', 'success');
    }

    public function showDeleted()
    {
        $produkTerhapus = M_Produk::onlyTrashed()->get();
        return view('admin.V_ProdukTerhapus', compact('produkTerhapus'));
    }

    public function restore($id)
    {
        $produk = M_Produk::onlyTrashed()->findOrFail($id);
        $produk->restore();

        return redirect()->route('produk.deleted')->with('lightbox_message', 'Produk berhasil dipulihkan.')->with('lightbox_type', 'success');
    }

    public function forceDelete($id)
    {
        $produk = M_Produk::onlyTrashed()->findOrFail($id);
        if ($produk->foto) {
            \Storage::disk('public')->delete($produk->foto);
        }
        $produk->forceDelete();

        return redirect()->route('produk.deleted')->with('lightbox_message', 'Produk dihapus permanen.')->with('lightbox_type', 'success');
    }
}
