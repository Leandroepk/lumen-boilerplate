<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use App\Traits\Uuids;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    protected $table = 'users';
    use Authenticatable, Authorizable, Uuids, SoftDeletes;
    protected $hidden = ['password'];
    protected $fillable = ['username', 'password'];
}
