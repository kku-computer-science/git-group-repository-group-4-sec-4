<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserActionPerformed
{
    use Dispatchable, SerializesModels;

    public $user;
    public $action;
    public $route;

    public function __construct($user, $action, $route)
    {
        $this->user = $user;
        $this->action = $action;
        $this->route = $route;
    }
}
