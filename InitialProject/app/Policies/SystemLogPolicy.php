<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('system-log-list'); 
    }
}
