<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_name_th','department_name_en','program_name_zh',
    ];

    public function getProgramNameAttribute()
    {
        $locale = app()->getLocale();
        switch ($locale) {
            case 'th':
                return $this->program_name_th;
            case 'zh':
                return $this->program_name_zh;
            default:
                return $this->program_name_en;
        }
    }


    public function users()
    {
        return $this->hasMany(User::class);
        
    }
}
