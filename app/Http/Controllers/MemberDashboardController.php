<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user   = Auth::user();
        $member = $user->member;

        // Filtros
        $year  = $request->get('year');
        $month = $request->get('month');

        // $member = Auth::user()->member;

        // if (!$member) {
        //     abort(403, 'Usuário não possui perfil de membro.');
        // Essa e uma solucao ao member null



        $query = Donation::with(['category', 'user'])
            ->where('member_id', $member?->id);

        if ($year) {
            $query->whereYear('donation_date', $year);
        }

        if ($month) {
            $query->whereMonth('donation_date', $month);
        }

        $donations = $query
            ->orderByDesc('donation_date')
            ->paginate(10)
            ->withQueryString();

        // Total doado no período
        $totalDonated = (clone $query)->sum('amount');

        return view('members.dashboard', [
            'menu' => 'my-donations',
            'donations' => $donations,
            'totalDonated' => $totalDonated,
            'monthlyTithe' => $member?->monthly_tithe,
            'year' => $year,
            'month' => $month,
            'user' => Auth::user(),
        ]);
    }

    public function updateTithe(Request $request)
    {
        $request->validate([
            'monthly_tithe' => 'nullable|numeric|min:0',
        ]);

        $member = Auth::user()->member;

        $member->update([
            'monthly_tithe' => $request->monthly_tithe,
        ]);

        return redirect()
            ->route('members.dashboard')
            ->with('success', 'Valor do dízimo atualizado com sucesso.');
    }
}
