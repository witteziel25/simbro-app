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
                return $path;
            }
        }

        // Fallback jika proses GD gagal
        return $file->store($folder, 'public');
    }
}
