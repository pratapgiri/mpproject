<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallForPaper extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'date'
    ];
}
