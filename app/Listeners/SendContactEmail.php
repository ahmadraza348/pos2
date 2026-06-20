<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserContactSubmitted;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUserMail;


class SendContactEmail implements ShouldQueue
{
      public function handle(UserContactSubmitted $event): void
    {
        Mail::to($event->userContact->email)->queue(new ContactUserMail($event->userContact));
        
    }
}
