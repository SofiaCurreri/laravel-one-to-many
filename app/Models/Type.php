<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    //relazione 1 a N con Project
    public function project() {
        return $this->belongsTo(Project::class);
    }
}