<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'role_id',
    ];

}
