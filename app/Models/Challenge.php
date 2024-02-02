<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Challenge extends Model
{
    protected $fillable = ['title', 'description', 'difficulty', 'user_id'];
}
