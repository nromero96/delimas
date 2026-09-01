<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document_number',
        'name',
        'address',
        'district',
        'address_reference',
        'phone',
        'phone_two',
        'email',
        'restriction',
        'recommendation',
        'status',
    ];
}
