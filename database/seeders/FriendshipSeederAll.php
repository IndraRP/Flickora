<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FriendshipSeederAll extends Seeder
{
    public function run()
    {
        // Ambil semua user_id yang ada di tabel users
        $userIds = User::pluck('id')->toArray();

        // Buat friendships untuk setiap user
        foreach ($userIds as $userId) {
            // Tentukan jumlah friendships
            if ($userId >= 10 && $userId <= 20) {
                // Untuk user_id 10 - 20, jumlah friendships antara 100.000 - 800.000
                $friendshipCount = rand(100000, 800000);
            } else {
                // Untuk user lainnya, random antara 1 - 999
                $friendshipCount = rand(1, 999);
            }

            // Insert friendships
            $friendships = [];
            for ($i = 1; $i <= $friendshipCount; $i++) {
                $friendships[] = [
                    'user_id' => $userId,
                    'friend_id' => rand(1, 1000), // Anggap user id 1-1000 ada di tabel users
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Masukkan ke database (batch insert)
            $chunks = array_chunk($friendships, 1000);
            foreach ($chunks as $chunk) {
                DB::table('friendships')->insert($chunk);
            }

            // Info ke console
            $this->command->info("Friendships untuk user ID $userId berhasil ditambahkan: $friendshipCount friendships.");
        }

        $this->command->info('Semua friendships berhasil ditambahkan!');
    }
}
