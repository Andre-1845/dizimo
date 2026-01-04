<?php

if (! function_exists('money')) {
    function money($value): string
    {
        return number_format($value ?? 0, 2, ',', '.');
    }
}
