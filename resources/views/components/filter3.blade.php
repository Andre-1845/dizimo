@foreach ($config['fields'] as $field)
    <div>
        <label class="form-label">{{ $field['label'] }}</label>

        @switch($field['type'])
            @case('text')
                <input type="text" name="{{ $field['name'] }}" value="{{ request($field['name']) }}"
                    placeholder="{{ $field['placeholder'] ?? '' }}" class="form-input">
            @break

            @case('date')
                <input type="date" name="{{ $field['name'] }}" value="{{ request($field['name']) }}" class="form-input">
            @break

            @case('select')
                <select name="{{ $field['name'] }}" class="form-input">
                    @foreach ($field['options'] as $value => $label)
                        <option value="{{ $value }}" @selected((string) request($field['name']) === (string) $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            @break
        @endswitch
    </div>
@endforeach
