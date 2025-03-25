<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserAvatarSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'foto1.jpg',
            'foto2.jpg',
            'foto3.jpg',
            'foto4.jpg',
            'foto5.jpg'
        ];

        Storage::disk('public')->makeDirectory('users-avatar');

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $randomImage = $images[array_rand($images)];

            $newFileName = Str::random(10) . '-' . $randomImage;

            File::copy(public_path('images/' . $randomImage), storage_path('app/public/users-avatar/' . $newFileName));

            DB::table('users')->where('id', $user->id)->update([
                'avatar' => 'users-avatar/' . $newFileName,
                'updated_at' => now(),
            ]);
        }
    }
}
