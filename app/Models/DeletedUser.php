<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedUser extends Model
{
    protected $table = 'deleted_users';

    protected $fillable = [
        'name','user_name','email','deleted_by'
    ];
}
