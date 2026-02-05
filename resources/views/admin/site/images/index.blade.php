@extends('layouts.admin')

@section('title', 'Imagens da Seção')

@section('content')

    <h1 class="content-title">
        Imagens — {{ $section->title }}
    </h1>

    <form method="POST" action="{{ route('admin.site.images.store', $section) }}" enctype="multipart/form-data"
        class="mb-6 flex gap-4 items-center">
        @csrf

        <input type="file" name="image" class="file-input" required>
        <input type="text" name="caption" placeholder="Legenda" class="form-input">

        <button class="btn-primary">Enviar</button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($images as $image)
            <div class="border rounded p-2">
                <img src="{{ $image->image_url }}" class="w-full h-40 object-cover rounded" alt="{{ $image->caption }}">

                <p class="text-xs mt-1 text-gray-600">
                    {{ $image->caption }}
                </p>

                <form method="POST" action="{{ route('admin.site.images.destroy', $image) }}">
                    @csrf
                    @method('DELETE')

                    <button class="text-red-600 text-sm mt-2">
                        Remover
                    </button>
                </form>
            </div>
        @endforeach
    </div>

@endsection
