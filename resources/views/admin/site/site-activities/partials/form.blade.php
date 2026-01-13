<div>
    <label class="block form-label">Nome da Atividade</label>
    <input type="text" name="name" value="{{ old('name', $activity->name ?? '') }}" class="form-input">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block form-label">Dia</label>
        <input type="text" name="day" value="{{ old('day', $activity->day ?? '') }}" class="form-input">
    </div>

    <div>
        <label class="block form-label">Horário</label>
        <input type="text" name="time" value="{{ old('time', $activity->time ?? '') }}" class="form-input">
    </div>
</div>

<div>
    <label class="block form-label">E-mail (opcional)</label>
    <input type="email" name="email" value="{{ old('email', $activity->email ?? '') }}" class="form-input">
</div>
<div>
    <label class="block form-label">Telefone de contato (opcional)</label>
    <input type="text" name="phone" placeholder="(21) 99999-9999"
        value="{{ old('phone', $activity->phone ?? '') }}" class="form-input">
</div>

<div>
    <label class="block form-label">
        Link de agendamento (página do site)
    </label>
    <input type="text" name="schedule_link" placeholder="/confissoes ou /agendar"
        value="{{ old('schedule_link', $activity->schedule_link ?? '') }}" class="form-input">
</div>
<div class="flex items-center gap-2">
    <input type="hidden" name="active" value="0">

    <input type="checkbox" name="active" value="1"
        {{ old('active', $activity->active ?? true) ? 'checked' : '' }}>
    <label>Ativo</label>
</div>


<div>
    <label class="block form-label">
        Ordem de exibição
    </label>
    <input type="number" name="order" min="0" value="{{ old('order', $activity->order ?? 0) }}"
        class="form-input">
    <p class="text-sm text-gray-500 mt-1">
        Quanto menor o número, mais acima a atividade aparece.
    </p>
</div>
