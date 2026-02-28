<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Limpa o cache após salvar
        cache()->forget("setting_{$key}");

        return $setting;
    }

    public static function get($key, $default = null)
    {
        return cache()->rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function deleteKey($key)
    {
        static::where('key', $key)->delete();
        cache()->forget("setting_{$key}");
    }
}
