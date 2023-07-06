<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'thumbnail',
        'body'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(CourseCategory::class);
    }

    public function scopeSelectLatest($query) {
        return $query->select('id', 'title', 'slug', 'thumbnail', 'user_id')
                    ->with('author')->latest();
    }
}
