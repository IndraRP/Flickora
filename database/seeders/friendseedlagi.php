<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class friendseedlagi extends Seeder
{
    public function run()
    {
        // User ID 1 - 23
        $userIds = range(10, 20); // Misalnya user ID 1 sampai 23

        foreach ($userIds as $userId) {
            $friendships = [];

            // Tentukan jumlah friendships untuk masing-masing user
            $friendshipCount = rand(50000, 100000); // Antara 50.000 hingga 100.000 friendships per user

            // Menggunakan duplikasi untuk mencapai friendshipCount
            for ($i = 1; $i <= $friendshipCount; $i++) {
                // Mengambil friend_id secara acak antara 1 dan 23
                $friendId = rand(10, 20);

                // Jika user_id sama dengan friend_id (self-friendship), kita hindari
                if ($userId == $friendId) {
                    continue;
                }

                $friendships[] = [
                    'user_id' => $userId,
                    'friend_id' => $friendId,  // friend_id acak dalam rentang 1-23
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Batch insert untuk efisiensi (insert data secara bertahap)
            $chunks = array_chunk($friendships, 1000); // Insert dalam chunk untuk mencegah kelebihan memori
            foreach ($chunks as $chunk) {
                DB::table('friendships')->insert($chunk);
            }
        }

        $this->command->info('Friendships untuk user ID 1 - 23 berhasil ditambahkan dengan duplikasi!');
    }
}
