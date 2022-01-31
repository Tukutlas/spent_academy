<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $table = 'user_access';

    public function sections()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
}
