{{-- resources/views/users/index.blade.php --}}
@extends('layouts.panel')

@push('head')
    {{-- simple-datatables (CSS) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div id="infoPanel" class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios</h1>

        {{-- Mensaje de bienvenida --}}
        <div id="mensajeBienvenida" class="bg-white p-4 shadow rounded mb-6">
            <p class="text-gray-700 leading-relaxed">
                Bienvenido, Administrador. Desde este panel tienes acceso completo para visualizar, editar, registrar y
                eliminar usuarios dentro del sistema, con excepción de los usuarios con rol
                <strong>Superadministrador</strong>, cuya gestión está reservada por razones de seguridad.
                <br><br>
                Asegúrate de verificar cuidadosamente la información antes de aplicar cambios, ya que estos pueden afectar
                el acceso y los permisos de los usuarios.
                <br><br>
                Si necesitas realizar acciones avanzadas, como la gestión de roles especiales o restaurar cuentas
                eliminadas, por favor comunícate con el equipo de soporte técnico a través de los canales oficiales.
            </p>
        </div>

        {{-- Tabla de usuarios --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="export-table" class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr class="text-gray-600 uppercase text-xs tracking-wider">
                        {{-- Columna ID (se oculta via JS, sirve para ordenar DESC) --}}
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse(($users ?? collect()) as $usuario)
                        <tr class="hover:bg-gray-50" data-user-id="{{ $usuario->id }}">
                            <td class="px-4 py-2">{{ $usuario->id }}</td>
                            <td class="px-4 py-2">
                                {{ $usuario->first_name }} {{ $usuario->last_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $usuario->email }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $usuario->roles->pluck('name')->implode(', ') ?: 'sin rol' }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center justify-center gap-4">
                                    @can('users.manage')
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md
                                                              hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400
                                                              focus:ring-offset-1 transition flex-none">
                                            Editar
                                        </a>
                                    @endcan

                                    @php $isSuperAdmin = $usuario->hasRole('superadmin'); @endphp
                                    @if(!$isSuperAdmin && auth()->user()->can('users.delete'))
                                        {{-- Botón Eliminar --}}
                                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                            onsubmit="return confirm('¿Eliminar este usuario?')" class="flex-none">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-1.5 text-sm font-medium text-white bg-red-600 rounded-md
                                                                       hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400
                                                                       focus:ring-offset-1 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No hay usuarios para mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- simple-datatables (JS) --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

    <script>
        if (document.getElementById("export-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const table = new simpleDatatables.DataTable("#export-table", {
                // Misma cabecera horizontal que el superadmin.blade.php
                template: (options, dom) =>
                    "<div class='" + options.classes.top + "'>" +
                    "<div class='flex flex-row items-center justify-between gap-4'>" +
                    // Izquierda: selector per page
                    (options.paging && options.perPageSelect
                        ? "<div class='flex items-center gap-2'>" +
                        "<label class='flex items-center gap-2'>" +
                        "<select class='" + options.classes.selector + " border-gray-300 rounded-md'></select>" +
                        "<span class='text-sm text-gray-600'>por página</span>" +
                        "</label>" +
                        "</div>"
                        : ""
                    ) +
                    // Centro: Export
                    "<div class='relative'>" +
                    "<button id='exportDropdownButton' type='button' class='flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none'>" +
                    "Exportar" +
                    "<svg class='ml-1 h-4 w-4' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>" +
                    "<path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7'/>" +
                    "</svg>" +
                    "</button>" +
                    "<div id='exportDropdown' class='z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow-sm'>" +
                    "<ul class='p-2 text-sm text-gray-500' aria-labelledby='exportDropdownButton'>" +
                    "<li><button id='export-csv'  class='w-full px-3 py-2 text-left hover:bg-gray-100'>Export CSV</button></li>" +
                    "<li><button id='export-json' class='w-full px-3 py-2 text-left hover:bg-gray-100'>Export JSON</button></li>" +
                    "<li><button id='export-txt'  class='w-full px-3 py-2 text-left hover:bg-gray-100'>Export TXT</button></li>" +
                    "<li><button id='export-sql'  class='w-full px-3 py-2 text-left hover:bg-gray-100'>Export SQL</button></li>" +
                    "</ul>" +
                    "</div>" +
                    "</div>" +
                    // Derecha: buscador nativo del DataTable
                    (options.searchable
                        ? "<div class='" + options.classes.search + " w-64'>" +
                        "<input class='" + options.classes.input + " w-full rounded-md border-gray-300' placeholder='Buscar…' type='search' title='Buscar en la tabla' " + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
                        "</div>"
                        : ""
                    ) +
                    "</div>" +
                    "</div>" +
                    "<div class='" + options.classes.container + "'></div>" +
                    "<div class='" + options.classes.bottom + "'>" +
                    (options.paging ? "<div class='" + options.classes.info + "'></div>" : "") +
                    "<nav class='" + options.classes.pagination + "'></nav>" +
                    "</div>",

                // Oculta la columna 0 (ID) y ordénala DESC para ver más recientes primero
                columns: [{ select: 0, hidden: true, sort: 'desc' }],
                perPage: 10,
                searchable: true,
                fixedHeight: false,
                labels: {
                    placeholder: 'Buscar…',
                    perPage: 'por página',
                    noRows: 'No se encontraron registros',
                    info: 'Mostrando {start}–{end} de {rows}',
                    searchTitle: 'Buscar en la tabla'
                }
            });

            // --- Export handlers ---
            document.getElementById("export-csv")?.addEventListener("click", () => {
                simpleDatatables.exportCSV(table, { download: true, columnDelimiter: ";", lineDelimiter: "\n" });
            });
            document.getElementById("export-json")?.addEventListener("click", () => {
                simpleDatatables.exportJSON(table, { download: true, space: 2 });
            });
            document.getElementById("export-txt")?.addEventListener("click", () => {
                simpleDatatables.exportTXT(table, { download: true });
            });
            document.getElementById("export-sql")?.addEventListener("click", () => {
                simpleDatatables.exportSQL(table, { download: true, tableName: "usuarios" });
            });

            // --- Toggle simple para el dropdown de Exportar (sin Flowbite) ---
            const btn = document.getElementById('exportDropdownButton');
            const dd = document.getElementById('exportDropdown');
            btn?.addEventListener('click', (e) => {
                e.stopPropagation();
                dd?.classList.toggle('hidden');
            });
            document.addEventListener('click', () => dd?.classList.add('hidden'));

            // --- Highlight de fila recién creada si llega ?highlight=ID ---
            const params = new URLSearchParams(window.location.search);
            const highlightId = params.get('highlight');
            if (highlightId) {
                // Espera al render de la tabla
                setTimeout(() => {
                    const row = document.querySelector(`tr[data-user-id="${highlightId}"]`);
                    if (row) {
                        row.classList.add('ring-2', 'ring-indigo-400', 'ring-offset-2');
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => row.classList.remove('ring-2', 'ring-indigo-400', 'ring-offset-2'), 4000);
                    }
                }, 250);
            }
        }
    </script>
@endpush
