<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Communication extends Model
{
    use Notifiable;

    protected $fillable = [
      'email', 'subject', 'message', 'accepted', 'send_to'
    ];

    public function routeNotificationForMail()
    {
        return $this->send_to;
    }
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }
}
