<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function group_member()
    {
        return $this->hasMany('App\Models\GroupMember', 'group_id', 'id')->with('member_name');
    }
}
