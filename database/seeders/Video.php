<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Video extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Array video sample
        $videoSamples = [
            'https://samplelib.com/lib/preview/mp4/sample-5s.mp4',
            'https://samplelib.com/lib/preview/mp4/sample-10s.mp4',
            'https://samplelib.com/lib/preview/mp4/sample-20s.mp4',
        ];

        foreach (range(1, 10) as $index) {
            try {
                // Pilih video secara acak
                $videoUrl = $videoSamples[array_rand($videoSamples)];

                // Buat nama file random
                $fileName = 'videos/' . $faker->uuid . '.mp4';

                // Simpan file ke storage
                $videoContent = file_get_contents($videoUrl);
                if ($videoContent === false) {
                    throw new \Exception("Gagal mengunduh video.");
                }

                Storage::disk('public')->put($fileName, $videoContent);

                // Ambil user_id yang valid (hanya dari id 1-10)
                $user = User::whereBetween('id', [1, 10])->inRandomOrder()->first();

                if ($user) {
                    // Insert ke tabel videos
                    DB::table('videos')->insert([
                        'user_id' => $user->id,
                        'content' => $faker->paragraph,
                        'video' => $fileName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        }
    }
}
