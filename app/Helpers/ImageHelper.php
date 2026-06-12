<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Mengkonversi gambar yang diunggah menjadi WebP dan menyimpannya di disk public.
     *
     * @param UploadedFile $file
     * @param string $folder Folder tujuan di dalam storage/app/public/
     * @return string Path file yang tersimpan untuk database
     */
    public static function convertAndStoreAsWebp(UploadedFile $file, string $folder): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        // Jika format aslinya tidak dikenali, simpan apa adanya (sebagai fallback)
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            if (env('CLOUDINARY_URL')) {
                try {
                    \Cloudinary\Configuration\Configuration::instance(env('CLOUDINARY_URL'));
                    $cloudinary = new \Cloudinary\Cloudinary();
                    $uploadResult = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                        'folder' => 'simbro/' . $folder
                    ]);
                    return $uploadResult['secure_url'];
                } catch (\Exception $e) {
                    \Log::error('Cloudinary early fallback upload failed: ' . $e->getMessage());
                }
            }
            return $file->store($folder, 'public');
        }

        $filename = uniqid('img_', true) . '_' . time() . '.webp';
        $path = $folder . '/' . $filename;
        
        // Pastikan folder di dalam public disk sudah ada
        Storage::disk('public')->makeDirectory($folder);
        $absolutePath = storage_path('app/public/' . $path);

        $image = null;
        if (in_array($extension, ['jpg', 'jpeg'])) {
            $image = @imagecreatefromjpeg($file->getRealPath());
        } elseif ($extension == 'png') {
            $image = @imagecreatefrompng($file->getRealPath());
        } elseif ($extension == 'webp') {
            $image = @imagecreatefromwebp($file->getRealPath());
        }

        if ($image) {
            // Jaga transparansi jika aslinya PNG / WebP
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            
            // Konversi dan simpan ke format WebP dengan kualitas 80%
            $success = @imagewebp($image, $absolutePath, 80);
            imagedestroy($image);
            
            if ($success) {
                // Jika integrasi Cloudinary diaktifkan
                if (env('CLOUDINARY_URL')) {
                    try {
                        \Cloudinary\Configuration\Configuration::instance(env('CLOUDINARY_URL'));
                        $cloudinary = new \Cloudinary\Cloudinary();
                        $uploadResult = $cloudinary->uploadApi()->upload($absolutePath, [
                            'folder' => 'simbro/' . $folder
                        ]);
                        
                        // Hapus file lokal karena sudah ada di cloud
                        @unlink($absolutePath);
                        
                        // Kembalikan URL Cloudinary secara langsung
                        return $uploadResult['secure_url'];
                    } catch (\Exception $e) {
                        // Jika gagal upload ke cloudinary, biarkan menggunakan path lokal
                        \Log::error('Cloudinary upload failed: ' . $e->getMessage());
                    }
                }
                
                return $path;
            }
        }

        // Fallback jika proses GD gagal
        // Cek jika Cloudinary aktif untuk fallback file non-GD (png/jpg yang gagal diconvert)
        if (env('CLOUDINARY_URL')) {
            try {
                \Cloudinary\Configuration\Configuration::instance(env('CLOUDINARY_URL'));
                $cloudinary = new \Cloudinary\Cloudinary();
                $uploadResult = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'simbro/' . $folder
                ]);
                return $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary fallback upload failed: ' . $e->getMessage());
            }
        }
        
        
        return $file->store($folder, 'public');
    }

    /**
     * Mendapatkan URL gambar, apakah dari Storage lokal atau Cloudinary
     */
    public static function getUrl(?string $path): ?string
    {
        if (!$path) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return Storage::url($path);
    }
}
