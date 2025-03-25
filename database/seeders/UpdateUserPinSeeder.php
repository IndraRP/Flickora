<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateUserPinSeeder extends Seeder
{
    public function run()
    {
        User::query()->update([
            'pin' => Hash::make('12345')
        ]);
    }
}
