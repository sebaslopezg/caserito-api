<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Venta;
use App\Models\Producto;

class Items extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'precio',
        'cantidad',
    ];

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function producto(){
        return $this->hasMany(Producto::class);
    }
}
