<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;
    public function member_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
