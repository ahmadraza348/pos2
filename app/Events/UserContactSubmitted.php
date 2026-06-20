<?php

namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserContactSubmitted
{
    use Dispatchable, SerializesModels; 

    public $userContact;
    public function __construct($userContact)
    {
        $this->userContact = $userContact;
    }
}
