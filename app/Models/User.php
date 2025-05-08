<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    public $timestamps = false;

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }
}
