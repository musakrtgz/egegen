<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ImageUploadService
{
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        // klaösür oluştur
        Storage::disk('public')->makeDirectory($folder);

        // dosya yolları
        $fileName = uuid_create() . '.' . $file->extension();
        $savePath = storage_path('app/public/' . $folder . '/' . $fileName);

        // resmi 800x800'ü geçmeyecek şekilde yeniden boyutlandır
        \Spatie\Image\Image::load($file->getPathname())
            ->manualCrop(800, 800)
            ->save($savePath);

        // pathi dön
        return $folder . '/' . $fileName;
    }
}
