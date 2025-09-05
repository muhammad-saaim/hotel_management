<?php

namespace App\Jobs;

use App\Models\Room;
use App\Models\User;
use App\Notifications\NewRoomAvailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessNewRoom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function handle()
    {
        $customers = User::all(); // All users in users table
        Notification::send($customers, new NewRoomAvailable($this->room));
    }
}
