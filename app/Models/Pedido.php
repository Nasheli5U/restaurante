<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_pedido',
        'mesa',
        'total'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'pedido_items')->withPivot('cantidad')->withTimestamps();
    }
}
