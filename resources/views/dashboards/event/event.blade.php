<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Eventos</h1>

    {{-- Buscador + Crear + Logout (opcional) --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
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
                    placeholder="Buscar por título, ubicación…"
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
            <button type="button" onclick="nuevoEvento()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow block text-center">
                Registrar Evento
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
    <section id="tablaEventos">
        <table class="min-w-full table-auto text-sm text-left border-collapse border">
            <thead class="bg-gray-100 border-b">
            <tr class="text-gray-600 uppercase text-xs tracking-wider">
                <th class="px-4 py-3">Título</th>
                <th class="px-4 py-3">Inicio</th>
                <th class="px-4 py-3">Fin</th>
                <th class="px-4 py-3">Ubicación</th>
                <th class="px-4 py-3">Capacidad</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="tbodyEventos">
            @forelse(($events ?? collect()) as $ev)
                <tr class="hover:bg-gray-50 transition fila-evento">
                    <td class="px-4 py-2">{{ $ev->title }}</td>
                    <td class="px-4 py-2">{{ optional($ev->start_at)->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">{{ optional($ev->end_at)->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">{{ $ev->location ?? '—' }}</td>
                    <td class="px-4 py-2 text-center">{{ $ev->capacity ?? '—' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-xs
                            {{ ($ev->status ?? 'activo') === 'activo' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $ev->status ?? 'activo' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center flex gap-2 justify-center">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                onclick="editarEvento({{ $ev->id }})">
                            Editar
                        </button>
                        <form method="POST" action="{{ route('events.destroy', $ev) }}"
                              onsubmit="return eliminarEvento(event)">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay eventos registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Paginación (si aplica) --}}
        @if(isset($events) && method_exists($events, 'links'))
            <div class="mt-6 flex justify-center">
                {{ $events->links('pagination::tailwind') }}
            </div>
        @endif
    </section>

    {{-- Formulario crear/editar --}}
    <section id="formEventoWrapper" class="hidden mt-10">
        <h2 id="tituloFormEvento" class="text-xl font-semibold mb-6 text-gray-700">Registrar Evento</h2>

        <form id="formEvento" method="POST" action="{{ route('events.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodHidden" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="title" id="title" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="activo">activo</option>
                        <option value="inactivo">inactivo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Inicio</label>
                    <input type="datetime-local" name="start_at" id="start_at"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fin</label>
                    <input type="datetime-local" name="end_at" id="end_at"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="location" id="location"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Capacidad</label>
                    <input type="number" min="1" name="capacity" id="capacity"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                {{-- Asignar Ponentes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Ponentes</label>
                    <select name="speakers[]" id="speakers" multiple size="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach(($speakersOptions ?? ($speakersAll ?? collect())) as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->full_name }} {{ $sp->company ? '— '.$sp->company : '' }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Mantén Ctrl/Cmd para seleccionar múltiples.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" id="btnGuardarEvento"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Guardar
                </button>
                <button type="button" onclick="cancelarEvento()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    Cancelar
                </button>
            </div>
        </form>
    </section>
</div>

<script>
    // Datos base para edición
    const eventos  = @json(($events ?? collect())->toArray()['data'] ?? ($events ?? collect()));
    const ponentes = @json(($speakersOptions ?? $speakersAll ?? collect()));

    function nuevoEvento() {
        document.getElementById('tablaEventos').classList.add('hidden');
        document.getElementById('formEventoWrapper').classList.remove('hidden');
        document.getElementById('tituloFormEvento').textContent = 'Registrar Evento';
        const form = document.getElementById('formEvento');
        form.reset();
        form.action = @json(route('events.store'));
        document.getElementById('methodHidden').value = 'POST';
        // Limpia selección de ponentes
        const sel = document.getElementById('speakers');
        Array.from(sel.options).forEach(o => o.selected = false);
    }

    function editarEvento(id) {
        const ev = (Array.isArray(eventos) ? eventos.find(e => e.id === id) : null);
        if (!ev) return alert('Evento no encontrado');

        document.getElementById('tablaEventos').classList.add('hidden');
        document.getElementById('formEventoWrapper').classList.remove('hidden');
        document.getElementById('tituloFormEvento').textContent = 'Editar Evento';

        const form = document.getElementById('formEvento');
        form.action = `/events/${id}`;
        document.getElementById('methodHidden').value = 'PUT';

        const setDT = (v) => v ? new Date(v).toISOString().slice(0,16) : '';

        // Relleno
        form['title'].value       = ev.title ?? '';
        form['status'].value      = ev.status ?? 'activo';
        form['start_at'].value    = setDT(ev.start_at ?? ev.startAt ?? null);
        form['end_at'].value      = setDT(ev.end_at ?? ev.endAt ?? null);
        form['location'].value    = ev.location ?? '';
        form['capacity'].value    = ev.capacity ?? '';
        form['description'].value = ev.description ?? '';

        // Ponentes seleccionados (si el backend los envía embebidos como ev.speakers)
        const sel = document.getElementById('speakers');
        Array.from(sel.options).forEach(o => o.selected = false);
        if (Array.isArray(ev.speakers)) {
            const ids = new Set(ev.speakers.map(s => s.id));
            Array.from(sel.options).forEach(o => { if (ids.has(Number(o.value))) o.selected = true; });
        }
    }

    function cancelarEvento() {
        document.getElementById('formEvento').reset();
        document.getElementById('formEventoWrapper').classList.add('hidden');
        document.getElementById('tablaEventos').classList.remove('hidden');
    }

    // Envío AJAX
    document.getElementById('formEvento').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);

        try {
            const resp = await axios.post(form.action, fd, { headers: { 'Accept': 'application/json' }});
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

    function eliminarEvento(ev) {
        if (!confirm('¿Eliminar este evento?')) { ev.preventDefault(); return false; }
        return true;
    }

    // Clear search
    document.getElementById('btnClearSearch')?.addEventListener('click', function () {
        const searchInput = document.getElementById('search');
        searchInput.value = '';
        document.querySelectorAll('.fila-evento').forEach(fila => fila.style.display = '');
        window.location.href = window.location.pathname;
    });
</script>

</body>
</html>
