<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $event = Event::first(); // Assuming you have events seeded
        $user = User::first(); // Assuming you have users seeded

        Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'content' => 'This is a test comment for the event.',
        ]);
    }
}
