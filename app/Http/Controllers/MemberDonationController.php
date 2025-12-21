<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Models\Category;
use App\Models\Donation;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberDonationController extends Controller
{
    public function create()
    {
        $user = Auth::User();

        return view('members.create_donation', [
            'user' => $user,
            'categories' => Category::where('type', 'income')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    public function store(DonationRequest $request)
    {

        $data = $request->validated();

        $user = Auth::user();
        $data['donor_name'] = $user->member->name;

        // Upload do comprovante
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')
                ->store('receipts/donations', 'public');
        }

        Donation::create([
            ...$data,
            'member_id' => $user->member->id,
            'user_id'   => $user->id,
        ]);

        Log::info('Doação cadastrada', ['user_id' => $user->id]);

        return redirect()
            ->route('dashboard.member')
            ->with('success', 'Doação registrada com sucesso.');
    }
}
