<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorProfile extends Model
{
    use SoftDeletes;
    protected $table = 'instriuctor_profile';
}
