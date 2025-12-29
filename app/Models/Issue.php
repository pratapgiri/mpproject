<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'year_id',
        'issues',
        'status',
    ];


    public function year()
{
    return $this->belongsTo(Year::class, 'year_id');
}
}
