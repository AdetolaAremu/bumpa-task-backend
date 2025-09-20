<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadges extends Model
{
    protected $guarded = ['id'];

    public function badges()
    {
        return $this->hasOne(Badge::class, 'id', 'badge_id');
    }
}
