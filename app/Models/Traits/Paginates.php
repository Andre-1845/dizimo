<?php

namespace App\Models\Traits;

trait Paginates
{
    protected function perPage(): int
    {
        $perPage = request('per_page', session('per_page', 10));

        session(['per_page' => $perPage]);

        return (int) $perPage;
    }
}
