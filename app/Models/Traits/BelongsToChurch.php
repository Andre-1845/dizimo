<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToChurch
{
    protected static function bootBelongsToChurch()
    {
        static::addGlobalScope('church', function (Builder $builder) {

            if (!auth()->check()) {
                return;
            }

            $churchId = session('view_church_id');

            if ($churchId) {
                $builder->where('church_id', $churchId);
            }
        });
    }
}
