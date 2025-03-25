<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // Pastikan ini ada

class UpdateDarkModeSeeder extends Seeder
{
    public function run()
    {
        // Update semua user untuk menggunakan dark mode (dark_mode = 1)
        DB::table('users')->update(['dark_mode' => 1]);

        $this->command->info('Semua pengguna telah diubah ke mode gelap!');
    }
}
