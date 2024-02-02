<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Company extends Model
{   
    protected $fillable = ['name', 'location', 'industry', 'user_id'];
}
