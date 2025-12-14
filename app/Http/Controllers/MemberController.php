<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::orderBy('name')->paginate(10);

        return view('members.index', [
            'members' => $members,
            'menu' => 'members',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create', [
            'menu' => 'members',
        ]);
    }



    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->has('active');

        $validated = validator($data, [
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email',
            'phone'  => 'nullable|string|max:20',
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
        return view('members.edit', [
            'member' => $member,
            'menu' => 'members',
        ]);
    }
    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Member $member)
    {
        $data = $request->all();
        $data['active'] = $request->has('active');

        $validated = validator($data, [
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email',
            'phone'  => 'nullable|string|max:20',
            'active' => 'boolean',
        ])->validate();

        $member->update($data);

        return redirect()
            ->route('members.index')
            ->with('success', 'Membro atualizado com sucesso.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Membro removido com sucesso.');
    }
}
