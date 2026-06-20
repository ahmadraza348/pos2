<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserContactSubmitted;
use Illuminate\Support\Facades\Log;


class LogContactSubmission implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    public function handle(UserContactSubmitted $event)
    {
        Log::info('New contact', [
            'email' => $event->userContact->email,            
            'subject' => $event->userContact->subject,
        ]);
    }
}
