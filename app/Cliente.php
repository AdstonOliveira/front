<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ["id","nome", "endereco", "telefone","idade","filho"];
}
