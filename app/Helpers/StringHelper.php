<?php

namespace App\Helpers;

class StringHelper
{
    public static function formatName(string $name): string
    {
        $name = mb_strtolower(trim($name), 'UTF-8');

        $particles = [
            'de',
            'da',
            'do',
            'dos',
            'das',
            'e'
        ];

        $words = explode(' ', $name);

        $formatted = array_map(function ($word) use ($particles) {
            if (in_array($word, $particles)) {
                return $word;
            }

            return mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
        }, $words);

        return implode(' ', $formatted);
    }
}
