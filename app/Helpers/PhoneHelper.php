<?php

if (!function_exists('format_phone')) {

    function format_phone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        // Remove tudo que não for número
        $numbers = preg_replace('/\D/', '', $phone);

        // Celular (11 dígitos)
        if (strlen($numbers) === 11) {
            return sprintf(
                '(%s)%s-%s',
                substr($numbers, 0, 2),
                substr($numbers, 2, 5),
                substr($numbers, 7)
            );
        }

        // Fixo (10 dígitos)
        if (strlen($numbers) === 10) {
            return sprintf(
                '(%s)%s-%s',
                substr($numbers, 0, 2),
                substr($numbers, 2, 4),
                substr($numbers, 6)
            );
        }

        // Caso fora do padrão
        return $phone;
    }
}
