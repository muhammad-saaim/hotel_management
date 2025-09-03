<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class RoomImageSeeder extends Seeder
{
    public function run()
    {
        $files = Storage::disk('public')->files('rooms'); // ✅ ensures correct disk

        if (empty($files)) {
            $this->command->info('No images found in storage/app/public/rooms!');
            return;
        }

        Room::all()->each(function ($room) use ($files) {
            $room->update([
                'image' => $files[array_rand($files)]
            ]);
        });

        $this->command->info('Room images seeded successfully!');
    }
}
