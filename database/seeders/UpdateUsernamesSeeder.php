<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Support\Str;

class UpdateUsernamesSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Generate username dari email atau nama
            $username = $user->username ?? Str::slug(explode('@', $user->email)[0], '_');

            // Pastikan username unik
            $count = DB::table('users')->where('username', $username)->count();
            if ($count > 0) {
                $username .= '_' . Str::random(3);
            }

            // Update username di database
            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        }
    }
}
