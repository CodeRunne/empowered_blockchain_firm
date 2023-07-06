<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HireATeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'job_role',
        'budget',
        'description'
    ];
}
