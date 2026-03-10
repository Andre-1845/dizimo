<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Donation;
use App\Models\MemberTitheValue;

class FixDonationExpectedTithe extends Command
{
    protected $signature = 'app:fix-donation-expected-tithe';

    protected $description = 'Atualiza o campo expected_tithe das doações antigas';

    public function handle()
    {
        $this->info('Iniciando correção das doações...');

        $donations = Donation::whereNull('expected_tithe')->get();

        foreach ($donations as $donation) {

            if (!$donation->member_id) {
                continue;
            }

            $tithe = MemberTitheValue::where('member_id', $donation->member_id)
                ->where('start_date', '<=', $donation->donation_date)
                ->orderBy('start_date', 'desc')
                ->first();

            $donation->expected_tithe = $tithe?->value;
            $donation->save();
        }

        $this->info('Correção finalizada.');
    }
}
