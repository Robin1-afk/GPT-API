<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Challenge extends Model
{
    protected $fillable = ['name', 'email', 'image_path'];
}
