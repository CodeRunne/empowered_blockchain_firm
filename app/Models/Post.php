<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_published',
        'excerpt'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSelectLatest($query) {
        return $query->select('id', 'is_published', 'title', 'slug', 'excerpt', 'thumbnail', 'user_id')
                    ->with('author')->latest();
    }

    public function scopePublished($query) {
        $query->where('is_published', true);
    }

    public function scopeUnpublished($query) {
        $query->where('is_published', false);
    }
}