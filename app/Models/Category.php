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

    public function getIsUsedAttribute(): bool
    {
        return ($this->donations_count ?? 0) > 0
            || ($this->expenses_count ?? 0) > 0;
    }

    public function isUsed(): bool
    {
        return $this->donations()->exists()
            || $this->expenses()->exists();
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'income' => 'Receita',
            'expense' => 'Despesa',
            default => '-',
        };
    }

    public static function dizimo()
    {
        return static::where('name', 'Dízimo')->firstOrFail();
    }
}
