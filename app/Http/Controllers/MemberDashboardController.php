<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\Paginates;

class MemberDashboardController extends Controller
{
    use Paginates;

    public function index(Request $request)
    {
        $user   = Auth::user();
        $member = $user->member;

        // Proteção: usuário sem perfil de membro
        if (!$member) {
            abort(403, 'Usuário não possui perfil de membro.');
        }

        // Filtros
        $year  = $request->get('year');
        $month = $request->get('month');

        // 🔑 QUERY CORRETA (sem user)
        $query = Donation::where('member_id', $member->id)
            ->with(['category']);

        if ($year) {
            $query->whereYear('donation_date', $year);
        }

        if ($month) {
            $query->whereMonth('donation_date', $month);
        }

        $donations = $query
            ->orderByDesc('donation_date')
            ->paginate($this->perPage())
            ->withQueryString();

        // Total doado no período
        $totalDonated = (clone $query)->sum('amount');

        return view('members.dashboard', [
            'menu'         => 'dashboard-member',
            'donations'    => $donations,
            'totalDonated' => $totalDonated,
            'monthlyTithe' => $member->monthly_tithe,
            'year'         => $year,
            'month'        => $month,
            'user'         => $user,
        ]);
    }

    public function updateTithe(Request $request)
    {
        $request->validate([
            'monthly_tithe' => 'nullable|numeric|min:0',
        ]);

        $member = Auth::user()->member;

        if (!$member) {
            abort(403);
        }

        $member->update([
            'monthly_tithe' => $request->monthly_tithe,
        ]);

        return redirect()
            ->route('dashboard.member')
            ->with('success', 'Valor do dízimo atualizado com sucesso.');
    }
}
