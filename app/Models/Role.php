<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STUDENT = 1;
    const PARENT = 2;
    const TEACHER = 3;
    const ADMIN = 4;
}
