@extends('layouts.site')

@section('title', $sections['hero']->title ?? 'Igreja')

@section('content')

    {{-- HERO --}}
    @if (isset($sections['hero']))
        <section class="relative bg-gray-900 text-white">
            @if (isset($images['hero'][0]))
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $images['hero'][0]->image_path) }}"
                        class="w-full h-full object-cover opacity-60">
                </div>
            @endif

            <div class="relative max-w-5xl mx-auto px-6 py-32 text-center">
                <h1 class="text-4xl md:text-5xl font-bold">
                    {{ $sections['hero']->title }}
                </h1>
                <p class="mt-4 text-lg">
                    {{ $sections['hero']->subtitle }}
                </p>
            </div>
        </section>
    @endif

    {{-- BOAS-VINDAS --}}
    @if (isset($sections['welcome']))
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">
                    {{ $sections['welcome']->title }}
                </h2>
                <p class="text-gray-600">
                    {{ $sections['welcome']->content }}
                </p>
            </div>
        </section>
    @endif

    {{-- AGENDA --}}
    @if ($events->count())
        <section id="agenda" class="py-16 bg-gray-100">
            <div class="max-w-5xl mx-auto px-6">
                <h2 class="text-3xl font-bold mb-8 text-center">
                    Agenda
                </h2>

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($events as $event)
                        <div class="bg-white rounded shadow p-5">
                            <h3 class="font-semibold text-lg">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $event->event_date->format('d/m/Y') }}
                                @if ($event->time)
                                    – {{ $event->time }}
                                @endif
                            </p>
                            <p class="mt-2 text-gray-600">
                                {{ $event->description }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CONTATO --}}
    @if (isset($sections['contact']))
        <section id="contact" class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">
                    {{ $sections['contact']->title }}
                </h2>
                <p class="text-gray-600">
                    {{ $sections['contact']->content }}
                </p>
            </div>
        </section>
    @endif
@endsection
