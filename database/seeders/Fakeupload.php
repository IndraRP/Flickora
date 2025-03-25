<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;

class Fakeupload extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $images = ['foto1.jpg', 'foto2.jpg', 'foto3.jpg', 'foto4.jpg', 'foto5.jpg'];

        // Ambil semua user
        $users = User::all();

        foreach ($users as $user) {
            // Setiap user memiliki 5-12 postingan
            $postCount = rand(3, 14);

            for ($i = 0; $i < $postCount; $i++) {
                Post::create([
                    'user_id' => $user->id,
                    'content' => $faker->sentence(rand(5, 15)), // Kalimat acak 5-12 kata
                    'image' => $images[array_rand($images)], // Pilih gambar acak
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
