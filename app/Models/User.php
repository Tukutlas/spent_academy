<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model //implements AuthenticatableContract, AuthorizableContract
{
    //use Authenticatable, Authorizable, HasFactory;
    use softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email',
    // ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $table = 'users';
    protected $guarded = [];

    protected $hidden = ['password','created_at','updated_at','reset_token', 'apps'];


    public static function findByAuthToken($token)
    {
        return self::where('login_token',$token)->first();//->with('states', 'countries')->first();
    }

    // public function states()
    // {
    //     return $this->belongsTo('App\Models\States', 'state');
    // }

    // public function countries()
    // {
    //     return $this->belongsTo('App\Models\Countries', 'country');
    // }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y',strtotime($value));
    }
}
