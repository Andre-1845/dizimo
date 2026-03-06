<?php

namespace App\Observers;

use App\Models\Donation;

class DonationObserver
{
    /**
     * Antes de criar a doação
     */
    public function creating(Donation $donation)
    {
        // Se houver membro, salva o nome histórico
        if ($donation->member && !$donation->donor_name) {
            $donation->donor_name = $donation->member->name;
        }
    }

    /**
     * Antes de atualizar a doação
     */
    public function updating(Donation $donation)
    {
        // Se o member_id mudar, atualizar o donor_name
        if ($donation->isDirty('member_id') && $donation->member) {
            $donation->donor_name = $donation->member->name;
        }
    }
}
