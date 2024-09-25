<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_programprice',
        'id_idcustomer',
        'start_date',
        'end_date',
        'number_of_days',
        'quantity_of_menu',
        'unitprice_moment',
        'total_price',
        'status',
    ];
}
