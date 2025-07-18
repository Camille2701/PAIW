<?php

namespace App\Support;

use Illuminate\Notifications\Notifiable;

class GuestUser
{
    use Notifiable;

    public $email;
    public $first_name;
    public $last_name;

    public function __construct($email, $first_name = null, $last_name = null)
    {
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
