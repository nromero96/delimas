<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programprice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_program',
        'textcategoryprice',
        'color',
        'oneprice',
        'fiveprice',
        'tenprice',
        'twentyprice',
    ];

}
