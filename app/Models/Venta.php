<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'total',
        'recibido',
    ];

    public function items(){
        return $this->belongsTo(Items::class);
    }
}
