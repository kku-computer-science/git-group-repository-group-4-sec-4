<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'dateTime', 'role', 'activity', 'status',
    ];

    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
