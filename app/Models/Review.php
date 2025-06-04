<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'producto_id',
        'nombre',
        'comentario',
        'puntuacion',
        'status',
    ];

        public function productos(){
        return $this->belongsTo(Producto::class);
    }
}
