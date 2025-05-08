<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address'
    ];

    public $timestamps = false;

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }
}
