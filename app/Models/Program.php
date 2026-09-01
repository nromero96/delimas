<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function prices()
    {
        return $this->hasMany(Programprice::class, 'id_program')->orderBy('id');
    }

}
