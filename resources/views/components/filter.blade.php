@props(['config'])

<form method="GET" action="{{ route($config['route']) }}" class="bg-gray-50 border rounded-lg p-4 mb-4">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        @foreach ($config['fields'] as $field)
            <div>
                <label class="form-label">{{ $field['label'] }}</label>

                @switch($field['type'])
                    @case('text')
                        <input type="text" name="{{ $field['name'] }}" value="{{ request($field['name']) }}"
                            placeholder="{{ $field['placeholder'] ?? '' }}" class="form-input">
                    @break

                    @case('date')
                        <input type="date" name="{{ $field['name'] }}" value="{{ request($field['name']) }}"
                            class="form-input">
                    @break

                    @case('select')
                        <select name="{{ $field['name'] }}" class="form-input">
                            <option value="">Todos</option>

                            @foreach ($field['options'] as $option)
                                <option value="{{ $option->{$field['optionValue']} }}" @selected(request($field['name']) == $option->{$field['optionValue']})>
                                    {{ $option->{$field['optionLabel']} }}
                                </option>
                            @endforeach
                        </select>
                    @break
                @endswitch
            </div>
        @endforeach
    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button class="btn-primary">Filtrar</button>
        <a href="{{ route($config['route']) }}" class="btn-warning">Limpar</a>
    </div>
</form>
