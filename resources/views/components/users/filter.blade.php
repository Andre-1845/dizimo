@props([
    'roles' => collect(),
])

<form method="GET" action="{{ route('users.index') }}" class="bg-gray-50 p-4 rounded-md mb-4">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div>
            <label class="form-label">Nome</label>
            <input type="text" name="name" value="{{ request('name') }}" class="form-input"
                placeholder="Nome do usuário">
        </div>

        <div>
            <label class="form-label">E-mail</label>
            <input type="text" name="email" value="{{ request('email') }}" class="form-input" placeholder="E-mail">
        </div>

        <div>
            <label class="form-label">Status do usuário</label>
            <select name="status" class="form-input">
                <option value="">Todos</option>
                <option value="1" @selected(request('status') == '1')>Pendente</option>
                <option value="2" @selected(request('status') == '2')>Ativo</option>
                <option value="3" @selected(request('status') == '3')>Suspenso</option>
            </select>
        </div>

        <div>
            <label class="form-label">Papel</label>
            <select name="role" class="form-input">
                <option value="">Todos</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" @selected(request('role') === $role->name)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>


    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button class="btn-success">
            Pesquisar
        </button>

        <a href="{{ route('users.index') }}" class="btn-warning">
            Limpar
        </a>
    </div>
</form>
