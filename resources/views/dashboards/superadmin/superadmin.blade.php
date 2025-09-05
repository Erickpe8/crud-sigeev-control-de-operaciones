{{-- resources/views/users/superadmin.blade.php --}}
@extends('layouts.panel')

@push('head')
    {{-- simple-datatables CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div id="infoPanel" class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios — Superadmin</h1>

        <div id="mensajeBienvenida" class="bg-white p-4 shadow rounded mb-6">
            <p class="text-gray-700 leading-relaxed">
                Bienvenido, <strong>Superadministrador</strong>. Aquí puedes <strong>crear, editar, eliminar</strong> y
                <strong>asignar roles</strong> a cualquier usuario del sistema, incluidos administradores.
                <br><br>
                Por seguridad, no podrás <strong>auto-eliminarte ni auto-degradarte</strong> desde este panel.
            </p>
        </div>

        {{-- Tabla de usuarios --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="export-table" class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr class="text-gray-600 uppercase text-xs tracking-wider">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $usuario)
                        @php
                            $rolesStr = $usuario->roles->pluck('name')->implode(', ');
                            $isSuper = $usuario->hasRole('superadmin');
                            $isSelf = auth()->id() === $usuario->id;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $usuario->id }}</td>
                            <td class="px-4 py-2">{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                            <td class="px-4 py-2">{{ $usuario->email }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-0.5 rounded text-xs {{ $isSuper ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $rolesStr ?: 'sin rol' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center flex gap-2 justify-center">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                    onclick="editarUsuario({{ $usuario->id }})">
                                    Editar
                                </button>

                                @unless($isSuper || $isSelf)
                                    <form method="POST" action="{{ route('superadmin.usuarios.destroy', $usuario) }}"
                                        onsubmit="return confirm('¿Eliminar este usuario?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                            Eliminar
                                        </button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

    <script>
        if (document.getElementById("export-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const table = new simpleDatatables.DataTable("#export-table", {
                template: (options, dom) =>
                    "<div class='" + options.classes.top + "'>" +
                    "<div class='flex flex-row items-center justify-between gap-4'>" +
                    // izquierda: per page
                    (options.paging && options.perPageSelect
                        ? "<div class='flex items-center gap-2'>" +
                        "<label class='flex items-center gap-2'>" +
                        "<select class='" + options.classes.selector + " border-gray-300 rounded-md'></select>" +
                        "<span class='text-sm text-gray-600'>por página</span>" +
                        "</label>" +
                        "</div>"
                        : ""
                    ) +
                    // centro: export
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
                    // derecha: buscador
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
                columns: [{ select: 0, hidden: true, sort: 'desc' }],
                perPage: 10,
                searchable: true,
                labels: {
                    placeholder: 'Buscar…',
                    perPage: 'por página',
                    noRows: 'No se encontraron registros',
                    info: 'Mostrando {start}–{end} de {rows}',
                    searchTitle: 'Buscar en la tabla'
                }
            });

            // Export handlers
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
        }
    </script>
@endpush
