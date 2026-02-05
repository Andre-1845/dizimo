<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class DateExtract
{
    public static function year(string $column): string
    {
        return match (DB::getDriverName()) {
            'pgsql' => "EXTRACT(YEAR FROM {$column})",
            default => "YEAR({$column})", // mysql
        };
    }

    public static function month(string $column): string
    {
        return match (DB::getDriverName()) {
            'pgsql' => "EXTRACT(MONTH FROM {$column})",
            default => "MONTH({$column})", // mysql
        };
    }

    public static function day(string $column): string
    {
        return match (DB::getDriverName()) {
            'pgsql' => "EXTRACT(DAY FROM {$column})",
            default => "DAY({$column})", // mysql
        };
    }
}