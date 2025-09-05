<?php

namespace App\Notifications;

use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRoomAvailable extends Notification implements ShouldQueue
{
    use Queueable;

    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function via($notifiable)
    {
        return ['mail']; // Only email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Room Available!')
            ->line("A new room '{$this->room->name}' has been added.")
            ->line("Type: {$this->room->type}, Price: {$this->room->price}, Capacity: {$this->room->capacity}")
            ->action('View Rooms', url('/rooms'))
            ->line('Book now before it’s gone!');
    }
}
