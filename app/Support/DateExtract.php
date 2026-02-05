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
}