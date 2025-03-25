<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class gantifoto extends Seeder
{
    public function run()
    {
        $images = ['foto1.jpg', 'foto2.jpg', 'foto3.jpg', 'foto4.jpg', 'foto5.jpg'];
        $sourcePath = public_path('images'); // Folder asal di public/images
        $destinationPath = storage_path('app/public/post'); // Folder tujuan di storage

        // Pastikan folder tujuan ada
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        // Update setiap post dengan gambar yang baru
        Post::all()->each(function ($post) use ($images, $sourcePath, $destinationPath) {
            $randomImage = $images[array_rand($images)];
            $newFileName = uniqid() . '-' . $randomImage; // Buat nama unik

            // Salin file dari public/images ke storage/app/public/post
            if (File::exists($sourcePath . '/' . $randomImage)) {
                File::copy($sourcePath . '/' . $randomImage, $destinationPath . '/' . $newFileName);
                $post->update(['image' => 'post/' . $newFileName]);
            }
        });

        $this->command->info('Gambar pada tabel posts berhasil diperbarui dan disalin ke storage!');
    }
}
