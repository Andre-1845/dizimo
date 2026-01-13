@csrf

<div class="mb-4">
    <label class="block font-medium mb-1">Título</label>
    <input type="text" name="title" value="{{ old('title', $notice->title ?? '') }}"
        class="w-full border rounded px-3 py-2" required>
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Conteúdo</label>
    <textarea name="content" rows="4" class="w-full border rounded px-3 py-2" required>{{ old('content', $notice->content ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block font-medium mb-1">Início</label>
        <input type="date" name="starts_at"
            value="{{ old('starts_at', optional($notice->starts_at ?? null)->format('Y-m-d')) }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-medium mb-1">Expira em</label>
        <input type="date" name="expires_at"
            value="{{ old('expires_at', optional($notice->expires_at ?? null)->format('Y-m-d')) }}"
            class="w-full border rounded px-3 py-2">
    </div>
</div>

<div class="mb-6">
    <input type="hidden" name="is_active" value="0">

    <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1"
            {{ old('is_active', $notice->is_active ?? true) ? 'checked' : '' }}>
        <span class="ml-2">Aviso ativo</span>
    </label>
</div>
<p class="text-sm text-gray-500 mb-4">
    Avisos expirados deixam de aparecer automaticamente no site.
</p>


<button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
    Salvar
</button>
