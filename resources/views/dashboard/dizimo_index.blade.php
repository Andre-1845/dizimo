@extends('layouts.admin')

@section('title', 'Controle de Dízimos')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Dashboard de Dízimos</h1>

    {{-- FILTROS --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-6 items-end">
        <select name="month" class="border rounded p-2">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" @selected($month == $m)>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <select name="year" class="border rounded p-2">
            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
            @endfor
        </select>

        <button class="btn-primary">Filtrar</button>
    </form>

    {{-- CARDS FINANCEIROS --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <x-dashboard.card title="Dízimo Previsto" value="R$ {{ number_format($totalExpected, 2, ',', '.') }}" />
        <x-dashboard.card title="Arrecadado no Mês" value="R$ {{ number_format($totalCollected, 2, ',', '.') }}"
            valueClass="text-green-600" />
        <x-dashboard.card title="Em Falta" value="R$ {{ number_format($totalMissing, 2, ',', '.') }}"
            valueClass="text-red-600" />
        <x-dashboard.card title="Percentual" value="{{ $percentageCollected }}%" />
        <x-dashboard.card title="Arrecadado no Ano" value="R$ {{ number_format($totalCollectedYear, 2, ',', '.') }}" />
    </div>

    {{-- CARDS OPERACIONAIS --}}

    {{-- MEMBROS --}}

    <div
        class="bg-gray-100 rounded-xl border shadow-lg px-14 py-8
            flex justify-between text-center my-6
            max-w-sm mx-auto">


        <div>
            <p class="text-gray-500 text-sm mb-1">Membros Ativos</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $membersActiveCount }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 text-sm mb-1">Membros Inativos</p>
            <p class="text-2xl font-bold text-red-600">
                {{ $membersInactiveCount }}
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- PAGARAM --}}
        <div class="bg-green-100 rounded border shadow p-5">
            <p class="text-gray-500 text-sm">Membros Dizimistas</p>
            <p class="text-3xl font-bold text-green-600">{{ $membersPaidCount }}</p>
            <p class="text-lg font-semibold mt-1">
                R$ {{ money($membersPaidTotal) }}
            </p>

            <a href="{{ route('dizimos.paid', request()->query()) }}"
                class="btn-success mt-4 inline-flex items-center justify-center">
                Ver lista
            </a>
        </div>

        {{-- PENDENTES --}}
        <div class="bg-red-100 rounded border shadow p-5">
            <p class="text-gray-500 text-sm">Doações Pendentes</p>
            <p class="text-3xl font-bold text-red-600">{{ $membersPendingCount }}</p>
            <p class="text-lg font-semibold mt-1">
                R$ {{ money($membersPendingTotal) }}
            </p>

            <a href="{{ route('dizimos.pending', request()->query()) }}"
                class="btn-danger mt-4 inline-flex items-center justify-center">
                Ver lista
            </a>
        </div>

        {{-- ANÔNIMAS --}}
        <div class="bg-gray-100 rounded border shadow p-5">
            <p class="text-gray-500 text-sm">Doações Administrativas</p>
            <p class="text-3xl font-bold text-blue-600">{{ $anonymousCount }}</p>
            <p class="text-lg font-semibold mt-1">
                R$ {{ money($anonymousTotal) }}
            </p>

            <a href="{{ route('dizimos.anonymous', request()->query()) }}"
                class="btn-info mt-4 inline-flex items-center justify-center">
                Ver lançamentos
            </a>
        </div>

    </div>

@endsection
