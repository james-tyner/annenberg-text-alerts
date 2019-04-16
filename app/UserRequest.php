<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRequest extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email'
    ];
}
