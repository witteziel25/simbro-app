<?php

namespace App\Http\Controllers;

use App\Models\M_Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class C_Gallery extends Controller
{
    // --- HALAMAN TAMBAH GALLERY ---
    public function create()
    {
        return view('admin.gallery.V_Create');
    }

    // --- PROSES SIMPAN GALLERY ---
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:50',
            'keterangan' => 'required|string|max:255',
            'artikel'    => 'required|string|max:2000',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg|max:30000',
        ], [
            'judul.required'      => 'Judul harus diisi',
            'judul.max'           => 'Jumlah karakter maksimal adalah 50 karakter',
            'keterangan.required' => 'Keterangan harus diisi',
            'keterangan.max'      => 'Jumlah karakter maksimal adalah 255 karakter',
            'artikel.required'    => 'Isi artikel harus diisi',
            'artikel.max'         => 'Jumlah karakter maksimal adalah 2000 karakter',
            'gambar.required'     => 'Belum ada gambar yang dimuat',
            'gambar.image'        => 'File harus berupa gambar',
            'gambar.mimes'        => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max'          => 'Ukuran gambar maksimal 30 MB',
        ]);

        if ($validator->fails()) {
            // AJAX support
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Non-AJAX (fallback)
            $hasRequiredError = false;
            $hasMaxError = false;
            foreach ($validator->errors()->all() as $error) {
                if (str_contains($error, 'harus diisi') || str_contains($error, 'Belum ada gambar')) {
                    $hasRequiredError = true;
                }
                if (str_contains($error, 'maksimal')) {
                    $hasMaxError = true;
                }
            }
            $lightboxMessage = ($hasRequiredError && !$hasMaxError) ? 'Harap isi data dengan lengkap' : 'Harap isi data dengan benar';

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('lightbox_message', $lightboxMessage)
                ->with('lightbox_type', 'error');
        }

        $path = \App\Helpers\ImageHelper::convertAndStoreAsWebp($request->file('gambar'), 'gallery');

        M_Gallery::create([
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'artikel'    => $request->artikel,
            'gambar'     => $path,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Konten berhasil ditambahkan']);
        }

        return redirect()->route('admin.home', ['#gallery'])
            ->with('lightbox_message', 'Konten berhasil ditambahkan')
            ->with('lightbox_type', 'success');
    }

    // --- HALAMAN BACA ARTIKEL GALLERY ---
    public function show($id)
    {
        $gallery = M_Gallery::findOrFail($id);
        return view('admin.gallery.V_Artikel', compact('gallery'));
    }

    // --- HALAMAN UBAH GALLERY ---
    public function edit($id)
    {
        $gallery = M_Gallery::findOrFail($id);
        return view('admin.gallery.V_Edit', compact('gallery'));
    }

    // --- PROSES UPDATE GALLERY ---
    public function update(Request $request, $id)
    {
        $gallery = M_Gallery::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:50',
            'keterangan' => 'required|string|max:255',
            'artikel'    => 'required|string|max:2000',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg|max:30000',
        ], [
            'judul.required'      => 'Judul harus diisi',
            'judul.max'           => 'Jumlah karakter maksimal adalah 50 karakter',
            'keterangan.required' => 'Keterangan harus diisi',
            'keterangan.max'      => 'Jumlah karakter maksimal adalah 255 karakter',
            'artikel.required'    => 'Isi artikel harus diisi',
            'artikel.max'         => 'Jumlah karakter maksimal adalah 2000 karakter',
            'gambar.image'        => 'File harus berupa gambar',
            'gambar.mimes'        => 'Format gambar harus jpeg, png, atau jpg',
            'gambar.max'          => 'Ukuran gambar maksimal 30 MB',
        ]);

        if ($validator->fails()) {
            // AJAX support
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // Non-AJAX (fallback)
            $hasRequiredError = false;
            $hasMaxError = false;
            foreach ($validator->errors()->all() as $error) {
                if (str_contains($error, 'harus diisi')) $hasRequiredError = true;
                if (str_contains($error, 'maksimal')) $hasMaxError = true;
            }
            $lightboxMessage = ($hasRequiredError && !$hasMaxError) ? 'Harap isi data dengan lengkap' : 'Harap isi data dengan benar';

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('lightbox_message', $lightboxMessage)
                ->with('lightbox_type', 'error');
        }

        $data = [
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'artikel'    => $request->artikel,
        ];

        if ($request->hasFile('gambar')) {
            if ($gallery->gambar) Storage::disk('public')->delete($gallery->gambar);
            $data['gambar'] = \App\Helpers\ImageHelper::convertAndStoreAsWebp($request->file('gambar'), 'gallery');
        }

        $gallery->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Konten berhasil diubah']);
        }

        return redirect()->route('admin.home', ['#gallery'])
            ->with('lightbox_message', 'Konten berhasil diubah')
            ->with('lightbox_type', 'success');
    }

    // --- PROSES HAPUS GALLERY ---
    public function destroy($id)
    {
        $gallery = M_Gallery::findOrFail($id);
        if ($gallery->gambar) Storage::disk('public')->delete($gallery->gambar);
        $gallery->delete();

        return redirect()->route('admin.home', ['#gallery'])
            ->with('lightbox_message', 'Konten berhasil dihapus')
            ->with('lightbox_type', 'success');
    }
}
