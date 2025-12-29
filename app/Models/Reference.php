<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'article_id',
        'reference'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
