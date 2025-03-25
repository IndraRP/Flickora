<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usersplus extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $friendships = [];

        for ($i = 0; $i < 1000; $i++) { // Jumlah data yang ingin dimasukkan
            $userId = $users[array_rand($users)];
            $friendId = $users[array_rand($users)];

            // Cek agar tidak ada pertemanan dengan diri sendiri dan tidak duplikat
            if ($userId !== $friendId && !DB::table('friendships')->where('user_id', $userId)->where('friend_id', $friendId)->exists()) {
                $friendships[] = [
                    'user_id'    => $userId,
                    'friend_id'  => $friendId,
                    'status'     => "approved",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('friendships')->insert($friendships);
    }
}
