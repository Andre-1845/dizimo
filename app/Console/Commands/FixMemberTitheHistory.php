<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\MemberTitheValue;
use Carbon\Carbon;

class FixMemberTitheHistory extends Command
{
    protected $signature = 'tithe:fix-history';

    protected $description = 'Cria registro inicial de dízimo na MTV para membros que ainda não possuem histórico';

    public function handle()
    {
        $this->info('Verificando membros...');

        $members = Member::all();

        foreach ($members as $member) {

            $exists = MemberTitheValue::where('member_id', $member->id)->exists();

            if (!$exists) {

                MemberTitheValue::create([
                    'member_id' => $member->id,
                    'value' => $member->monthly_tithe,
                    'start_date' => Carbon::parse($member->created_at)->startOfMonth(),
                    'user_id' => null
                ]);

                $this->line("Histórico criado para membro ID {$member->id}");
            }
        }

        $this->info('Correção concluída.');
    }
}
