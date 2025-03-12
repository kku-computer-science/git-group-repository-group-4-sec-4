<?php
namespace App\Listeners;

use App\Events\UserActionPerformed;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    public function handle(UserActionPerformed $event)
    {
        Log::info("User {$event->user->id} performed action {$event->action} on route {$event->route}");
    }
}