<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    use HasFactory;

    protected $fillable = [
        'index',
        'nome',
        'alcance',
        'dano',
        'tipo_de_dano',
        'propriedade',
    ];
}
