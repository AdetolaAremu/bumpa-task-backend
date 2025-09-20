<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    protected $guarded = ['id'];

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function badges()
    {
        return $this->hasMany(Achievement::class);
    }
}
