<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function grades() {
        return $this->hasOne(Grade::class);
    }
}
