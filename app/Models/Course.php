<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Indicar o nome da tabela
    protected $table = 'courses';

    // Indicar quais colunas podem ser manipuladas
    protected $fillable = ['name'];
}
