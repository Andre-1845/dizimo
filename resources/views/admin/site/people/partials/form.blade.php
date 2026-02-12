<div>
    <label class="form-label">Nome</label>
    <input type="text" name="name" value="{{ old('name', $person->name ?? '') }}" class="form-input w-full">
</div>

<div>
    <label class="form-label">Função</label>
    <input type="text" name="role" value="{{ old('role', $person->role ?? '') }}" class="form-input w-full">
</div>

<div>
    <label class="form-label">Descrição (opcional)</label>
    <textarea name="description" rows="4" class="form-input w-full">{{ old('description', $person->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="form-label">Ordem</label>
        <input type="number" name="order" value="{{ old('order', $person->order ?? '') }}" class="form-input w-full">
    </div>

    <label class="flex items-center gap-2 mt-7">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $person->is_active ?? true))>
        <span>Ativo</span>
    </label>
</div>

{{-- FOTO --}}
<div>
    <label class="form-label">Foto</label>

    <input type="file" id="photo" accept="image/*" class="file-input">

    <input type="hidden" name="photo_cropped" id="photo_cropped">

    @if (!empty($person?->photo_path))
        <img src="{{ asset('storage/' . $person->photo_path) }}" class="mt-4 w-32 h-32 object-cover rounded-full">
    @endif

    <div class="mt-4 max-w-xs">
        <img id="photo-preview" class="hidden block max-w-full" style="max-height: 400px;">
    </div>

</div>

{{--  CROPPER --}}

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof Cropper === 'undefined') {
                console.error('Cropper.js NÃO foi carregado');
                return;
            }

            const input = document.getElementById('photo');
            const preview = document.getElementById('photo-preview');
            const hidden = document.getElementById('photo_cropped');
            const form = document.querySelector('form[action*="people"]');

            if (!input || !preview || !hidden || !form) {
                console.error('Elementos do Cropper não encontrados');
                return;
            }

            let cropper = null;

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');

                    if (cropper) cropper.destroy();

                    cropper = new Cropper(preview, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(file);
            });

            form.addEventListener('submit', function(e) {
                if (!cropper) return;

                e.preventDefault();

                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });

                hidden.value = canvas.toDataURL('image/jpeg');

                form.submit();
            });

        });
    </script>
@endpush
