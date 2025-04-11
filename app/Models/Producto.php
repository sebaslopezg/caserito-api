<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'stock',
        'precio',
    ];

    public function items(){
        return $this->belongsTo(Items::class);
    }
}
