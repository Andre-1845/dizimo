<div class="mb-4">
    <label>Título</label>
    <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" class="form-input" required>
</div>

<div class="mb-4">
    <label>Data</label>
    <input type="date" name="event_date"
        value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}" class="form-input"
        required>
</div>

<div class="mb-4">
    <label>Hora</label>
    <input type="time" name="time" value="{{ old('time', $event->time ?? '') }}" class="form-input">
</div>

<div class="mb-4">
    <label>Descrição</label>
    <textarea name="description" rows="4" class="form-textarea">{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label>
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $event->is_active ?? true))>
        Evento ativo
    </label>
</div>
