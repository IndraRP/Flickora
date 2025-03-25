<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAvatarBackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $backgrounds = [
            'https://i.pinimg.com/474x/bb/5b/53/bb5b535a149b179197bbae8a51e85809.jpg',
            'https://i.pinimg.com/474x/6c/31/70/6c3170d4c3e8f1c376953b12ebea5823.jpg',
            'https://i.pinimg.com/474x/74/f3/fc/74f3fc9168694e202e834e2edfad11f0.jpg',
            'https://i.pinimg.com/474x/18/a2/eb/18a2eb87e07a1e6787e427ec2d0c9039.jpg',
            'https://i.pinimg.com/474x/ed/5e/bc/ed5ebcaacdcf57c9f867595439ad9368.jpg'
        ];

        $avatars = [
            'https://i.pinimg.com/474x/0f/ea/42/0fea4234db8dfd0b47c6856be574fa0a.jpg',
            'https://i.pinimg.com/474x/01/31/19/013119f5eaa7661ca24b74c27bd15016.jpg',
            'https://i.pinimg.com/474x/0f/97/b0/0f97b023801fe513f74de4fbb3e35b3d.jpg',
            'https://i.pinimg.com/474x/ba/a9/92/baa992f00064666ca93efcd245a73f80.jpg',
            'https://i.pinimg.com/474x/03/47/b3/0347b3676e6f6b8757ff2315c5710d44.jpg'
        ];

        // Update semua user dengan background & avatar random
        User::all()->each(function ($user) use ($backgrounds, $avatars) {
            $user->update([
                'background' => $backgrounds[array_rand($backgrounds)],
                'avatar' => $avatars[array_rand($avatars)],
            ]);
        });

        $this->command->info('✅ Background dan avatar pengguna telah diperbarui!');
    }
}
