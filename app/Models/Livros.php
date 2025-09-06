<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livros extends Model
{
    protected $fillable = [
        'nome',
        'autor',
        'destinatario',
        'num_capitulos'
    ];
}

