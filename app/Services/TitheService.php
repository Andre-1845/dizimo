<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberTitheValue;

class TitheService
{
    /**
     * Atualiza o dízimo atual do membro e registra histórico.
     */
    public function updateTithe(Member $member, float $value): void
    {
        $startDate = now()->startOfMonth();

        $last = MemberTitheValue::where('member_id', $member->id)
            ->orderBy('start_date', 'desc')
            ->first();

        // Só cria novo registro se o valor mudou
        if (!$last || $last->value != $value) {

            MemberTitheValue::create([
                'member_id' => $member->id,
                'value' => $value,
                'start_date' => $startDate,
                'user_id' => auth()->id()
            ]);
        }

        // Atualiza valor atual no membro
        $member->update([
            'monthly_tithe' => $value
        ]);
    }

    /**
     * Retorna o dízimo válido em uma determinada data.
     */
    public function getTitheForDate(int $memberId, $date): ?float
    {
        $tithe = MemberTitheValue::where('member_id', $memberId)
            ->where('start_date', '<=', $date)
            ->orderBy('start_date', 'desc')
            ->first();

        return $tithe?->value;
    }
}
