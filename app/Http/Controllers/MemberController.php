<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\MemberUserService;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny', Member::class);
        $members = Member::with('user')

            // Nome do membro
            ->when(
                $request->filled('name'),
                fn($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            )

            // Email do usuário relacionado
            ->when(
                $request->filled('email'),
                fn($q) =>
                $q->whereHas('user', function ($query) use ($request) {
                    $query->where('email', 'like', '%' . $request->email . '%');
                })
            )

            // Status do membro (ativo / inativo)
            ->when(
                $request->filled('active'),
                fn($q) =>
                $q->where('active', $request->active)
            )

            // Data de cadastro (início)
            ->when(
                $request->filled('start_date'),
                fn($q) =>
                $q->whereDate('created_at', '>=', $request->start_date)
            )

            // Data de cadastro (fim)
            ->when(
                $request->filled('end_date'),
                fn($q) =>
                $q->whereDate('created_at', '<=', $request->end_date)
            )

            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        /**
         * 🔧 Configuração do filtro genérico
         */
        $filters = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Nome do membro',
                'placeholder' => 'Digite o nome',
            ],
            [
                'type' => 'text',
                'name' => 'email',
                'label' => 'E-mail do usuário',
                'placeholder' => 'Digite o e-mail',
            ],

            [
                'type' => 'select',
                'name' => 'active',
                'label' => 'Status',
                'options' => collect([
                    ['id' => '1', 'name' => 'Ativo'],
                    ['id' => '0', 'name' => 'Inativo'],
                ]),
                'value' => 'id',
                'labelField' => 'name',
            ],

            [
                'type' => 'date',
                'name' => 'start_date',
                'label' => 'Cadastro (de)',
            ],
            [
                'type' => 'date',
                'name' => 'end_date',
                'label' => 'Cadastro (até)',
            ],
        ];

        return view('members.index', [
            'menu'         => 'members',
            'members'      => $members,
            'filters' => $filters,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Member::class);

        return view('members.create', [
            'menu' => 'members',
        ]);
    }



    public function store(Request $request)
    {
        $this->authorize('create', Member::class);

        $data = $request->all();
        $data['active'] = $request->has('active');

        $validated = validator($data, [
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|digits_between:10,11',
            'monthly_tithe' => 'required|numeric|min:0',
            'active' => 'boolean',
        ])->validate();


        Member::create($validated);


        return redirect()
            ->route('members.index')
            ->with('success', 'Membro cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */

    //
    public function show(Member $member)
    {
        $this->authorize('view', $member);

        $member->load('user');

        return view('members.show', [
            'member' => $member,
            'menu' => 'members',
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Member $member)
    {
        $this->authorize('update', $member);

        $member->load('user');
        return view('members.edit', [
            'member' => $member,
            'menu' => 'members',
        ]);
    }
    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Member $member, MemberUserService $memberUserService)
    {
        $this->authorize('update', $member);

        $data = $request->all();
        $data['active'] = $request->has('active');

        $validated = validator($data, [
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|digits_between:10,11',
            'monthly_tithe' => 'required|numeric|min:0',
            'user_name'     => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:users,email',
            'active'        => 'boolean',
        ])->validate();

        DB::transaction(function () use ($member, $validated, $memberUserService) {

            // Atualiza MEMBER
            $member->update([
                'name'          => $validated['name'],
                'phone'         => $validated['phone'] ?? null,
                'monthly_tithe' => $validated['monthly_tithe'],
                'active'        => $validated['active'] ?? false,
            ]);

            // 🔑 Cria USER se necessário + envia e-mail
            $memberUserService->createUserIfNeeded(
                $member,
                $validated['email'] ?? null,
                $validated['user_name'] ?? null
            );

            // Atualiza nome do USER se já existir
            if ($member->user) {
                $member->user->update([
                    'name' => $validated['user_name'] ?? $member->name,
                ]);
            }
        });

        return redirect()
            ->route('members.index')
            ->with('success', 'Membro atualizado com sucesso.');
    }


    public function destroy(Member $member)
    {
        $this->authorize('delete', $member);

        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Membro removido com sucesso.');
    }
}