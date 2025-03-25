<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ Tambahkan ini
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua post dan update dengan lorem ipsum 15 kata
        $posts = DB::table('posts')->get();

        foreach ($posts as $post) {
            DB::table('posts')
                ->where('id', $post->id)
                ->update([
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius vel nulla vitae facilisis.',
                    'updated_at' => now(),
                ]);
        }
    }
}
