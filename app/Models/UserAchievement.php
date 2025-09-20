<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    protected $guarded = ['id'];

    public function achievements()
    {
        return $this->hasOne(Achievement::class, 'id', 'achievement_id');
    }
}
