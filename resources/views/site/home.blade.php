@extends('layouts.site')

@section('title', $sections['hero']->title ?? 'Igreja')

@section('content')

    {{-- HERO --}}
    @if (isset($sections['hero']))
        <section class="relative min-h-[70vh] flex items-center justify-center text-center text-white">

            {{-- Imagem --}}
            @if (isset($images['hero'][0]))
                <img src="{{ asset('storage/' . $images['hero'][0]->image_path) }}"
                    class="absolute inset-0 w-full h-full object-cover" />
            @endif

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black/60"></div>

            {{-- Conteúdo --}}
            <div class="relative max-w-3xl px-6">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    {{ $sections['hero']->title ?? '' }}
                </h1>

                <p class="mt-4 text-lg text-gray-200">
                    {{ $sections['hero']->subtitle ?? '' }}
                </p>

                <a href="#about"
                    class="inline-block mt-8 px-8 py-3 bg-blue-600 hover:bg-blue-700
                  rounded-full font-semibold transition">
                    Conheça nossa igreja
                </a>
            </div>
        </section>
    @endif


    {{-- BOAS-VINDAS --}}
    @if (isset($sections['welcome']))
        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-6 text-center">

                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    {{ $sections['welcome']->title ?? '' }}
                </h2>

                <p class="text-lg text-gray-600 leading-relaxed">
                    {{ $sections['welcome']->content ?? '' }}
                </p>

            </div>
        </section>
    @endif

    {{-- SOBRE --}}
    @if (isset($sections['about']))
        <section id="about" class="py-20 bg-gray-100">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

                {{-- Texto --}}
                <div>
                    <h2 class="text-3xl font-bold mb-4">
                        {{ $sections['about']->title ?? '' }}
                    </h2>

                    <p class="text-gray-700 leading-relaxed">
                        {{ $sections['about']->content ?? '' }}
                    </p>
                </div>

                {{-- Imagem --}}
                @if (isset($images['about'][0]))
                    <img src="{{ asset('storage/' . $images['about'][0]->image_path) }}" class="rounded-lg shadow-lg" />
                @endif

            </div>
        </section>
    @endif

    {{-- GALERIA --}}
    @if (isset($sections['gallery']))
        <section class="py-20 bg-gray-100">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6">
                @foreach ($sections['gallery']->images as $image)
                    <div class="aspect-square overflow-hidden rounded shadow">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}"
                            class="w-full h-full object-cover" />
                    </div>
                @endforeach
            </div>

        </section>
    @endif



    {{-- AGENDA --}}
    @if ($events->count())
        <section id="agenda" class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-center mb-12">
                    Agenda
                </h2>

                <div class="grid gap-8 md:grid-cols-3">
                    @foreach ($events as $event)
                        <div class="border rounded-lg p-6 shadow-sm hover:shadow-md transition">

                            <h3 class="font-semibold text-lg mb-2">
                                {{ $event->title }}
                            </h3>

                            <p class="text-sm text-gray-500">
                                {{ $event->event_date->format('d/m/Y') }}
                                @if ($event->time)
                                    – {{ $event->time }}
                                @endif
                            </p>

                            <p class="mt-4 text-gray-600 text-sm">
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
        <section id="contact" class="py-20 bg-gray-900 text-white">
            <div class="max-w-4xl mx-auto px-6 text-center">

                <h2 class="text-3xl font-bold mb-6">
                    {{ $sections['contact']->title ?? '' }}
                </h2>

                <p class="text-gray-300 mb-4">
                    {{ $sections['contact']->content ?? '' }}
                </p>

                <p class="text-sm text-gray-400">
                    {{ \App\Models\SiteSetting::get('address') }} <br>
                    {{ \App\Models\SiteSetting::get('phone') }}
                </p>

            </div>
        </section>
    @endif

@endsection
