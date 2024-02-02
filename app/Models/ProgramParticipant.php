<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramParticipant extends Model
{
    protected $fillable = ['program_id', 'entity_type', 'entity_id'];
}
