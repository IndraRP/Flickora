<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class AddPostsSeeder2 extends Seeder
{
    public function run()
    {
        $images = [
            "https://i.pinimg.com/474x/be/e8/2e/bee82e707166db92e92c8c9f0850cfa1.jpg",
            "https://i.pinimg.com/474x/9e/e4/c3/9ee4c3484d4880248bbc46c04a1a87bd.jpg",
            "https://i.pinimg.com/474x/6f/95/65/6f9565e194b54276c97540be2eb55fae.jpg",
            "https://i.pinimg.com/474x/52/3a/96/523a9604732caf5efdb762b311e0d043.jpg",
            "https://i.pinimg.com/474x/21/90/76/219076ccab89037577cfd33ad501f7c1.jpg",
            "https://i.pinimg.com/474x/fd/29/b1/fd29b1590c504ea7b84f9577f4be1919.jpg",
            "https://i.pinimg.com/474x/a5/d5/ef/a5d5ef9a1287394518e355119f168dfe.jpg",
            "https://i.pinimg.com/474x/a6/ca/b6/a6cab6ea4cf0d350db2dd71ba939e0c7.jpg",
            "https://i.pinimg.com/474x/c0/7e/42/c07e42600118d239147b13f8c9873459.jpg",
        ];

        // Ambil semua user_id yang valid dari tabel users
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->info('Tidak ada user di tabel users. Harap jalankan seeder users terlebih dahulu.');
            return;
        }

        for ($i = 1; $i <= 100; $i++) {
            DB::table('posts')->insert([
                'user_id'    => $userIds[array_rand($userIds)], // Ambil user_id yang valid
                'content'    => Str::random(50),
                'image'      => $images[array_rand($images)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Setiap 10 data, beri informasi progress
            if ($i % 10 == 0) {
                $this->command->info("$i posts telah berhasil disisipkan.");
            }
        }

        $this->command->info('Seeder posts selesai.');
    }
}
