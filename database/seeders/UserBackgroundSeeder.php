<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserBackgroundSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'bg1.jpg',
            'bg2.jpg',
            'bg3.jpg',
            'bg4.jpg',
            'bg5.jpg'
        ];

        Storage::disk('public')->makeDirectory('background');

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $randomImage = $images[array_rand($images)];

            $newFileName = Str::random(10) . '-' . $randomImage;

            File::copy(public_path('images/' . $randomImage), storage_path('app/public/background/' . $newFileName));

            DB::table('users')->where('id', $user->id)->update([
                'background' => 'background/' . $newFileName,
                'updated_at' => now(),
            ]);
        }
    }
}
