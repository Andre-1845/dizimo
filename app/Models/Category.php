<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'type'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'income' => 'Receita',
            'expense' => 'Despesa',
            default => '-',
        };
    }
}
