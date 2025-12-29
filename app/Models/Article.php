<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'year_id',
        'issues_id',
        'category_id',
        'qr_code',
        'title',
        'abstract',
        'keyword',
        'doi',
        'article',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationships
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issues_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function authors()
    {
        return $this->hasMany(Author::class, 'article_id');
    }

    public function references()
    {
        return $this->hasMany(Reference::class, 'article_id');
    }
}
