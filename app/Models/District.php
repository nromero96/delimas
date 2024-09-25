<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    public $timestamps = false; // Para deshabilia campos obligatorios de fecha registro u actualización

    use HasFactory;

    protected $fillable = [
        'name',
    ];

}
