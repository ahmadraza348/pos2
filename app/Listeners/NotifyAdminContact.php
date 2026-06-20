<?php

namespace App\Listeners;

use App\Events\UserContactSubmitted;
use App\Events\AdminNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminContact implements ShouldQueue
{

    public function handle(UserContactSubmitted  $event): void
    {
        event(new AdminNotificationEvent([
            'type' => 'contact',
            'title' => $event->userContact->name,
            'subject' => $event->userContact->subject,
        ]));
    }
}
