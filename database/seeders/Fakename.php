<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class Fakename extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('users')->get()->each(function ($user) use ($faker) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'name' => $faker->name,
                    'username' => $faker->userName,
                ]);
        });
    }
}
