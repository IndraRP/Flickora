<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Menambahkan 5 data banner dengan gambar yang telah ditentukan
        Banner::create([
            'image' => 'https://i.pinimg.com/474x/e5/53/04/e55304415e982064b606216bf57b1f60.jpg',
            'status' => 'active',
        ]);

        Banner::create([
            'image' => 'https://i.pinimg.com/474x/72/41/1a/72411ad5f760006029c6c4ce5da50738.jpg',
            'status' => 'active',
        ]);

        Banner::create([
            'image' => 'https://i.pinimg.com/474x/d1/52/dc/d152dc719044a27a04f32929fe84a357.jpg',
            'status' => 'active',
        ]);

        Banner::create([
            'image' => 'https://i.pinimg.com/474x/79/64/4c/79644c84b54fbe03685837869f5f64b5.jpg',
            'status' => 'active',
        ]);

        Banner::create([
            'image' => 'https://i.pinimg.com/474x/48/91/c5/4891c58852c5b8c36bcd159a11a8d327.jpg',
            'status' => 'active',
        ]);
    }
}
