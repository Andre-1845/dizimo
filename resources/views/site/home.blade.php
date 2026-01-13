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

                @if ($sections['welcome']->subtitle)
                    <p class="text-lg text-gray-600 leading-relaxed">{{ $sections['welcome']->subtitle }}</p>
                @endif

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

                    @if ($sections['about']->subtitle)
                        <p class=" mb-3 text-lg text-gray-600 leading-relaxed">{{ $sections['about']->subtitle }}</p>
                    @endif

                    <p class="text-gray-700 leading-relaxed">
                        {{ $sections['about']->content ?? '' }}
                    </p>

                    <a href="{{ route('site.team') }}" class="inline-block mt-6 text-blue-600 hover:underline font-medium">
                        Conheça nossa equipe
                    </a>
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

            <h2 class="text-3xl font-bold mx-6 mb-4">
                {{ $sections['gallery']->title ?? '' }}
            </h2>
            {{-- Loop das imagens --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6">
                @foreach ($sections['gallery']->images as $image)
                    <div class="aspect-square overflow-hidden rounded shadow">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}"
                            class="w-full h-full object-cover" />
                    </div>
                @endforeach
            </div>
            {{-- Loop das imagens --}}
        </section>
    @endif



    {{-- AGENDA --}}
    @if ($events->count())
        <section id="agenda" class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-center mb-4">
                    {{ $sections['agenda']->title ?? '' }}
                </h2>

                @if (!empty($sections['agenda']->subtitle))
                    <p class="text-center text-gray-600 mb-10">
                        {{ $sections['agenda']->subtitle }}
                    </p>
                @endif

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

    {{-- HORARIOS --}}
    @if ($sections['activities']->is_active ?? false)
        <section id="horarios" class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-center mb-4">
                    {{ $sections['activities']->title ?? '' }}
                </h2>

                @if (!empty($sections['activities']->subtitle))
                    <p class="text-center text-gray-600 mb-10">
                        {{ $sections['activities']->subtitle }}
                    </p>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                    Atividade
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                    Dia
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                    Horário
                                </th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">
                                    Contato
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @foreach ($activities as $activity)
                                <tr>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $activity->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $activity->day }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $activity->time }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex flex-col items-center gap-1 text-sm">

                                            @if (!empty($activity->schedule_link))
                                                <a href="{{ url($activity->schedule_link) }}"
                                                    class="text-blue-600 hover:underline">
                                                    Agendar
                                                </a>
                                            @endif

                                            @if (!empty($activity->email))
                                                <a href="mailto:{{ $activity->email }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ $activity->email }}
                                                </a>
                                            @endif

                                            @if (!empty($activity->phone))
                                                <a href="tel:{{ preg_replace('/\D/', '', $activity->phone) }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ format_phone($activity->phone) }}
                                                </a>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </section>
    @endif

    {{-- AVISOS --}}
    @if ($notices->count())
        <section id="avisos" class="py-12 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-2xl font-semibold mb-6 text-center">
                    Avisos da Igreja
                </h2>

                <div class="space-y-6">
                    @foreach ($notices as $notice)
                        <div class="bg-white border rounded p-6 shadow-sm">
                            <h3 class="text-lg font-semibold mb-2">
                                {{ $notice->title }}
                            </h3>

                            <p class="text-gray-700 whitespace-pre-line">
                                {{ $notice->content }}
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
