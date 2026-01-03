<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function periodoExtenso(int $month, int $year): string
    {
        return Carbon::create($year, $month, 1)
            ->translatedFormat('F/Y');
    }

    public static function periodoExtensoComPreposicao(int $month, int $year): string
    {
        return Carbon::create($year, $month, 1)
            ->translatedFormat('F \d\e Y');
    }
}
