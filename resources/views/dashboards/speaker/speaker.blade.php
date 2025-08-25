<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ponentes</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Ponentes</h1>

    {{-- Buscador + Crear + Logout (opcional) --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Buscador -->
        <form method="GET" class="flex-1">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1010 18a7.5 7.5 0 006.65-6.85z"/>
                    </svg>
                </div>

                <input
                    type="search" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Buscar por nombre, correo o empresa…"
                    class="block w-full p-4 pl-10 pr-36 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                           focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute right-2.5 bottom-2.5 flex gap-2">
                    <button type="button" id="btnClearSearch"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-sm px-4 py-2">
                        Limpiar
                    </button>
                    <button type="submit"
                            class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-4 py-2">
                        Buscar
                    </button>
                </div>
            </div>
        </form>

        <div class="flex gap-2">
            <button type="button" onclick="nuevoPonente()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow block text-center">
                Registrar Ponente
            </button>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow block text-center">
                Cerrar Sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>

    {{-- Tabla --}}
    <section id="tablaPonentes">
        <table class="min-w-full table-auto text-sm text-left border-collapse border">
            <thead class="bg-gray-100 border-b">
            <tr class="text-gray-600 uppercase text-xs tracking-wider">
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Correo</th>
                <th class="px-4 py-3">Empresa</th>
                <th class="px-4 py-3">Rol</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="tbodyPonentes">
            @forelse(($speakers ?? collect()) as $sp)
                <tr class="hover:bg-gray-50 transition fila-ponente">
                    <td class="px-4 py-2">{{ $sp->full_name }}</td>
                    <td class="px-4 py-2">{{ $sp->email ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $sp->company ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $sp->role ?? '—' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-xs
                            {{ ($sp->status ?? 'activo') === 'activo' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $sp->status ?? 'activo' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center flex gap-2 justify-center">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                onclick="editarPonente({{ $sp->id }})">
                            Editar
                        </button>
                        <form method="POST" action="{{ route('speakers.destroy', $sp) }}"
                              onsubmit="return eliminarPonente(event)">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay ponentes registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Paginación (si aplica) --}}
        @if(isset($speakers) && method_exists($speakers, 'links'))
            <div class="mt-6 flex justify-center">
                {{ $speakers->links('pagination::tailwind') }}
            </div>
        @endif
    </section>

    {{-- Formulario crear/editar --}}
    <section id="formPonenteWrapper" class="hidden mt-10">
        <h2 id="tituloFormPonente" class="text-xl font-semibold mb-6 text-gray-700">Registrar Ponente</h2>

        <form id="formPonente" method="POST" action="{{ route('speakers.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodHidden" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @php
                    $campos = [
                        'full_name' => ['label'=>'Nombre completo','type'=>'text','req'=>true],
                        'email'     => ['label'=>'Correo','type'=>'email','req'=>false],
                        'phone'     => ['label'=>'Teléfono','type'=>'text','req'=>false],
                        'company'   => ['label'=>'Empresa','type'=>'text','req'=>false],
                        'role'      => ['label'=>'Rol (ponente/panelista/mod.)','type'=>'text','req'=>false],
                    ];
                @endphp

                @foreach ($campos as $name => $cfg)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ $cfg['label'] }}</label>
                        <input type="{{ $cfg['type'] }}" name="{{ $name }}" id="{{ $name }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               {{ $cfg['req'] ? 'required' : '' }}>
                    </div>
                @endforeach

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Biografía</label>
                    <textarea name="bio" id="bio" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="activo">activo</option>
                        <option value="inactivo">inactivo</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" id="btnGuardarPonente"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Guardar
                </button>
                <button type="button" onclick="cancelarPonente()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    Cancelar
                </button>
            </div>
        </form>
    </section>
</div>

<script>
    // Datos base para edición rápida
    const ponentes = @json(($speakers ?? collect())->toArray()['data'] ?? ($speakers ?? collect()));

    function nuevoPonente() {
        document.getElementById('tablaPonentes').classList.add('hidden');
        document.getElementById('formPonenteWrapper').classList.remove('hidden');
        document.getElementById('tituloFormPonente').textContent = 'Registrar Ponente';
        const form = document.getElementById('formPonente');
        form.reset();
        form.action = @json(route('speakers.store'));
        document.getElementById('methodHidden').value = 'POST';
    }

    function editarPonente(id) {
        const sp = (Array.isArray(ponentes) ? ponentes.find(u => u.id === id) : null);
        if (!sp) return alert('Ponente no encontrado');

        document.getElementById('tablaPonentes').classList.add('hidden');
        document.getElementById('formPonenteWrapper').classList.remove('hidden');
        document.getElementById('tituloFormPonente').textContent = 'Editar Ponente';

        const form = document.getElementById('formPonente');
        form.action = `/speakers/${id}`;
        document.getElementById('methodHidden').value = 'PUT';

        // Relleno
        const fields = ['full_name','email','phone','company','role','bio','status'];
        fields.forEach(f => {
            if (form[f] !== undefined) form[f].value = (sp[f] ?? '');
        });
        if (!form['status'].value) form['status'].value = 'activo';
    }

    function cancelarPonente() {
        document.getElementById('formPonente').reset();
        document.getElementById('formPonenteWrapper').classList.add('hidden');
        document.getElementById('tablaPonentes').classList.remove('hidden');
    }

    // Envío AJAX (opcional; si prefieres submit normal, quita esto)
    document.getElementById('formPonente').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        try {
            const resp = await axios.post(form.action, formData, { headers: { 'Accept': 'application/json' }});
            alert('✅ Guardado correctamente');
            location.reload();
        } catch (error) {
            if (error.response?.status === 422) {
                const errs = error.response.data.errors || {};
                let msj = 'Corrige los siguientes errores:\n';
                Object.keys(errs).forEach(k => msj += `- ${k}: ${errs[k].join(', ')}\n`);
                alert(msj);
            } else {
                alert('❌ Error al guardar');
            }
        }
    });

    function eliminarPonente(ev) {
        if (!confirm('¿Eliminar este ponente?')) { ev.preventDefault(); return false; }
        // deja que el form haga submit normal (DELETE laravel)
        return true;
    }

    // Clear search
    document.getElementById('btnClearSearch')?.addEventListener('click', function () {
        const searchInput = document.getElementById('search');
        searchInput.value = '';
        document.querySelectorAll('.fila-ponente').forEach(fila => fila.style.display = '');
        window.location.href = window.location.pathname;
    });
</script>

</body>
</html>
