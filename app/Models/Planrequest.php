<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planrequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'product',
        'plan',
        'name',
        'phone',
        'payment',
        'voucher',
        'status'
    ];

}
