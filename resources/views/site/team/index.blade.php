@extends('layouts.site')

@section('title', $section->title ?? 'Nossa Equipe')

@section('content')
    <hr>
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Cabeçalho --}}
            <div class="text-center mb-14">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ $section->title ?? 'Nossa Equipe' }}
                </h1>

                @if (!empty($section?->subtitle))
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        {{ $section->subtitle }}
                    </p>
                @endif
            </div>

            {{-- Lista de pessoas --}}
            @if ($people->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

                    @foreach ($people as $person)
                        <div class="text-center">

                            {{-- Foto --}}
                            @if ($person->photo_url)
                                <img src="{{ $person->photo_url }}" alt="{{ $person->name }}"
                                    class="w-40 h-40 object-cover rounded-full mx-auto mb-4 shadow">
                            @else
                                <div
                                    class="w-40 h-40 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center text-gray-500">
                                    Sem foto
                                </div>
                            @endif

                            {{-- Nome --}}
                            <h3 class="text-lg font-semibold">
                                {{ $person->name }}
                            </h3>

                            {{-- Função --}}
                            <p class="text-gray-600">
                                {{ $person->role }}
                            </p>

                            {{-- Descrição --}}
                            @if ($person->description)
                                <p class="mt-3 text-sm text-gray-500">
                                    {{ $person->description }}
                                </p>
                            @endif
                        </div>
                    @endforeach

                </div>
            @else
                <p class="text-center text-gray-500">
                    Nenhuma informação disponível no momento.
                </p>
            @endif

        </div>
    </section>

@endsection
