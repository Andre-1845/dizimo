<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Indicar o nome da tabela
    protected $table = 'statuses';

    // Indicar as colunas que podem ser manipuladas (fillable)
    protected $fillable = ['name'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}