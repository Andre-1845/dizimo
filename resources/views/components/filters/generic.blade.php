@props(['filters', 'route'])


<form method="GET" action="{{ $route }}" class="bg-gray-50 border rounded-lg p-4 mb-4">


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        @foreach ($filters as $filter)
            <div>
                <label class="form-label">{{ $filter['label'] }}</label>

                {{-- TEXT --}}
                @if ($filter['type'] === 'text')
                    <input type="text" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}"
                        placeholder="{{ $filter['placeholder'] ?? '' }}" class="form-input">
                @endif

                {{-- NUMBER --}}
                @if ($filter['type'] === 'number')
                    <input type="number" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}"
                        placeholder="{{ $filter['placeholder'] ?? '' }}" class="form-input">
                @endif

                {{-- DATE --}}
                @if ($filter['type'] === 'date')
                    <input type="date" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}"
                        class="form-input">
                @endif

                {{-- SELECT --}}
                @if ($filter['type'] === 'select')
                    <select name="{{ $filter['name'] }}" class="form-input">
                        <option value="">Todos</option>

                        @foreach ($filter['options'] as $option)
                            <option value="{{ data_get($option, $filter['value']) }}" @selected(request($filter['name']) == data_get($option, $filter['value']))>
                                {{ data_get($option, $filter['labelField']) }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach

    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button class="btn-success">Filtrar</button>
        <a href="{{ $route }}" class="btn-warning">Limpar</a>
    </div>
</form>
