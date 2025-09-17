{{-- resources/views/users/superadmin.blade.php --}}
@extends('layouts.panel')

@push('head')
    {{-- CSRF para Axios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- simple-datatables CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
        {{-- Contenedor de notificaciones (arriba a la derecha) --}}
        <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

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
            <div id="tablaUsuarios" class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                            <tr class="hover:bg-gray-50 transition fila-usuario">
                                <td class="px-4 py-2">{{ $usuario->id }}</td>
                                <td class="px-4 py-2">{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                                <td class="px-4 py-2">{{ $usuario->email }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-0.5 rounded text-xs {{ $isSuper ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $rolesStr ?: 'sin rol' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center flex gap-2 justify-center">
                                    {{-- Botón Editar con URL real de update --}}
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                        data-user-id="{{ $usuario->id }}"
                                        data-update-url="{{ route('superadmin.usuarios.update', $usuario) }}"
                                        onclick="editarUsuario(this)">
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

            {{-- Formulario de edición (oculto hasta presionar "Editar") --}}
            <section id="formularioEdicion" class="hidden mt-10">
                <h2 class="text-xl font-semibold mb-6 text-gray-700">Editar Usuario</h2>

                <form id="formEditarUsuario" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @php
                            $camposTexto = [
                                'first_name' => 'Primer Nombre',
                                'last_name' => 'Apellido',
                                'email' => 'Correo Electrónico',
                                'birthdate' => 'Fecha de Nacimiento',
                                'document_number' => 'Número de Documento',
                                'phone' => 'Teléfono', // incluido
                            ];
                        @endphp

                        @foreach ($camposTexto as $id => $label)
                            <div>
                                <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                <input
                                    type="{{ $id === 'email' ? 'email' : ($id === 'birthdate' ? 'date' : 'text') }}"
                                    id="{{ $id }}" name="{{ $id }}" value=""
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        @endforeach

                        @foreach ([
                                    'gender_id' => $genders ?? collect(),
                                    'document_type_id' => $documentTypes ?? collect(),
                                    'user_type_id' => $userTypes ?? collect(),
                                ] as $id => $collection)
                            <div>
                                <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
                                    {{ ucwords(str_replace('_', ' ', $id)) }}
                                </label>
                                <select id="{{ $id }}" name="{{ $id }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900"
                                        onchange="toggleCamposEspeciales()">
                                    <option value="">Seleccione</option>
                                    @foreach ($collection as $item)
                                        <option value="{{ $item->id }}">{{ $item->name ?? $item->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        {{-- Rol (Spatie) --}}
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                            <select id="role" name="role"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                                @foreach (($roles ?? collect()) as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">El cambio de rol se aplica al guardar.</p>
                        </div>

                        {{-- Campos adicionales dinámicos --}}
                        <div id="academic_section" class="col-span-2 hidden">
                            <div class="mb-4">
                                <label for="academic_program_id" class="block text-sm font-medium text-gray-700">Programa Académico</label>
                                <select id="academic_program_id" name="academic_program_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                                    <option value="">Seleccione</option>
                                    @foreach (($academicPrograms ?? collect()) as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución</label>
                                <select id="institution_id" name="institution_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                                    <option value="">Seleccione</option>
                                    @foreach (($institutions ?? collect()) as $inst)
                                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="empresa_section" class="col-span-2 hidden">
                            <div class="mb-4">
                                <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
                                <input type="text" id="company_name" name="company_name"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="company_address" class="block text-sm font-medium text-gray-700">Dirección de la Empresa</label>
                                <input type="text" id="company_address" name="company_address"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 md:justify-end">
                        <button type="submit" id="btnActualizar" disabled
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded opacity-50 cursor-not-allowed">
                            Actualizar
                        </button>
                        <button type="button" onclick="cancelarEdicion()"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                            Cancelar
                        </button>
                    </div>
                </form>
            </section>
        </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@5.0.2/dist/jspdf.plugin.autotable.min.js"></script>

    <script>
        /**
         * Inyecta el token CSRF en Axios para peticiones seguras.
         * @param — IIFE autoejecutable sin parámetros.
         * @returns {void} Configura axios.defaults.headers.
         */
        (function setupAxiosCsrf() {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        })();

        const GENDERS_MAP   = @json(isset($genders) ? $genders->pluck('name', 'id') : collect());
        const DOC_TYPES_MAP = @json(
        isset($documentTypes)
            ? $documentTypes->mapWithKeys(fn($d) => [$d->id => ($d->name ?? $d->type ?? '')])
            : collect()
        );
        const USUARIOS = @json(($users instanceof \Illuminate\Pagination\AbstractPaginator) ? ($users->toArray()['data'] ?? []) : $users);

        /**
         * Convierte una fecha ISO a formato dd/mm/yyyy.
         * @param {string} iso Cadena de fecha ISO o similar.
         * @returns {string} Fecha en dd/mm/yyyy; si falla, retorna la entrada.
         */
        function formatDateISOtoDMY(iso) {
        if (!iso) return '';
        try {
            const parts = String(iso).split('T')[0].split('-');
            if (parts.length === 3) {
            const [y,m,d] = parts;
            return `${d.padStart(2,'0')}/${m.padStart(2,'0')}/${y}`;
            }
            const d = new Date(iso);
            if (isNaN(d.getTime())) return iso;
            const dd = String(d.getUTCDate()).padStart(2,'0');
            const mm = String(d.getUTCMonth()+1).padStart(2,'0');
            const yyyy = d.getUTCFullYear();
            return `${dd}/${mm}/${yyyy}`;
        } catch { return iso; }
        }

        /**
         * Mapea el dataset de usuarios a filas legibles para exportar.
         * @param {Array<Object>} source Lista de usuarios crudos.
         * @returns {Array<Object>} Filas con claves amigables para Excel/PDF.
         */
        function buildExportRows(source) {
        if (!Array.isArray(source)) return [];
        return source.map(u => {
            const genero  = (u.gender_id != null)        ? (GENDERS_MAP[String(u.gender_id)] ?? GENDERS_MAP[u.gender_id] ?? '') : '';
            const docType = (u.document_type_id != null) ? (DOC_TYPES_MAP[String(u.document_type_id)] ?? DOC_TYPES_MAP[u.document_type_id] ?? '') : '';
            return {
            'Nombre': (u.first_name ?? ''),
            'Apellido': (u.last_name ?? ''),
            'Correo': (u.email ?? ''),
            'Fecha de nacimiento': formatDateISOtoDMY(u.birthdate ?? ''),
            'Género': genero,
            'Tipo de documento': docType,
            'N.º documento': (u.document_number ?? ''),
            'Teléfono': (u.phone ?? ''),
            };
        });
        }

        /**
         * Genera y descarga un Excel usando SheetJS.
         * @param {Array<Object>} rows Filas a exportar; @param {string} [fileName='usuarios.xlsx'] Nombre de archivo.
         * @returns {void} Crea workbook y dispara la descarga.
         */
        function exportExcel(rows, fileName = 'usuarios.xlsx') {
        if (!rows?.length) return alert('No hay datos para exportar.');
        const ws = XLSX.utils.json_to_sheet(rows, { header: Object.keys(rows[0]) });
        const colWidths = Object.keys(rows[0]).map(k => ({ wch: Math.max(k.length, ...rows.map(r => String(r[k] ?? '').length)) + 2 }));
        ws['!cols'] = colWidths;
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Usuarios');
        XLSX.writeFile(wb, fileName);
        }

        /**
         * Genera y descarga un PDF usando jsPDF + autoTable.
         * @param {Array<Object>} rows Filas a exportar; @param {string} [fileName='usuarios.pdf'] Nombre de archivo.
         * @returns {void} Crea el PDF y dispara la descarga.
         */
        function exportPDF(rows, fileName = 'usuarios.pdf') {
        if (!rows?.length) return alert('No hay datos para exportar.');
        const { jsPDF } = window.jspdf || {};
        const hasJsPDF = typeof jsPDF === 'function';
        const hasAutoTable = !!(jsPDF && jsPDF.API && typeof jsPDF.API.autoTable === 'function');
        if (!hasJsPDF || !hasAutoTable) {
            console.error('jsPDF o autoTable no disponibles', { hasJsPDF, hasAutoTable, jsPDF });
            alert('Librerías de PDF no disponibles.');
            return;
        }
        const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'A4' });
        const headers = [Object.keys(rows[0])];
        const body = rows.map(r => headers[0].map(h => r[h] ?? ''));
        doc.setFontSize(12);
        doc.text('Usuarios', 40, 40);
        doc.autoTable({
            startY: 60,
            head: headers,
            body,
            styles: { fontSize: 9, cellPadding: 4, overflow: 'linebreak' },
            headStyles: { fillColor: [41, 98, 255], textColor: 255 },
            margin: { left: 40, right: 40 },
            tableWidth: 'auto',
        });
        doc.save(fileName);
        }

        /**
         * Inicializa la tabla de usuarios (si existe) y agrega UI de exportación.
         * @param — Se ejecuta al detectar #export-table y DataTable disponible.
         * @returns {void} Configura paginación, búsqueda y menús de exportación.
         */
        if (document.getElementById("export-table") && typeof simpleDatatables?.DataTable !== 'undefined') {
        const table = new simpleDatatables.DataTable("#export-table", {
            template: (options, dom) =>
            "<div class='" + options.classes.top + "'>" +
                "<div class='flex flex-row items-center justify-between gap-4'>" +
                (options.paging && options.perPageSelect
                    ? "<div class='flex items-center gap-2'>" +
                    "<label class='flex items-center gap-2'>" +
                    "<select class='" + options.classes.selector + " border-gray-300 rounded-md'></select>" +
                    "<span class='text-sm text-gray-600'>por página</span>" +
                    "</label></div>"
                    : ""
                ) +
                "<div class='relative'>" +
                    "<button id='exportDropdownButton' type='button' class='flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none'>Exportar" +
                    "<svg class='ml-1 h-4 w-4' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7'/></svg>" +
                    "</button>" +
                    "<div id='exportDropdown' class='absolute right-0 mt-2 z-10 hidden w-48 rounded-lg bg-white shadow-sm ring-1 ring-black/5'>" +
                    "<ul class='p-2 text-sm text-gray-700' aria-labelledby='exportDropdownButton'>" +
                        "<li><button id='export-excel' class='w-full px-3 py-2 text-left hover:bg-gray-100'>Exportar a Excel</button></li>" +
                        "<li><button id='export-pdf'   class='w-full px-3 py-2 text-left hover:bg-gray-100'>Exportar a PDF</button></li>" +
                    "</ul>" +
                    "</div>" +
                "</div>" +
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
            columns: [{ select: 0, hidden: true, sort: 'asc' }],
            perPage: 100,
            perPageSelect: [50, 100, 200],
            searchable: true,
            labels: {
            placeholder: 'Buscar…',
            perPage: 'por página',
            noRows: 'No se encontraron registros',
            info: 'Mostrando {start}–{end} de {rows}',
            searchTitle: 'Buscar en la tabla'
            }
        });

        /**
         * Repara el selector de registros por página y fuerza 100 por defecto.
         * @param — Callback del evento interno datatable.init.
         * @returns {void} Rellena opciones y dispara change inicial.
         */
        table.on('datatable.init', () => {
            const selector = table.wrapper?.querySelector('select.dataTable-selector');
            if (!selector) return;
            const desired = ['50','100','200'];
            const current = Array.from(selector.options).map(o => o.value);
            if (desired.join(',') !== current.join(',')) {
            selector.innerHTML = '';
            desired.forEach(v => {
                const opt = document.createElement('option');
                opt.value = v;
                opt.textContent = v;
                selector.appendChild(opt);
            });
            }
            selector.value = '100';
            selector.dispatchEvent(new Event('change'));
        });

        const btn = document.getElementById('exportDropdownButton');
        const menu = document.getElementById('exportDropdown');

        /**
         * Obtiene el dataset filtrado según el término de búsqueda actual.
         * @param — Sin parámetros; lee el input de búsqueda del plugin.
         * @returns {Array<Object>} Subconjunto de usuarios que coinciden.
         */
        function currentFilter() {
            const q = document.querySelector('.dataTable-input')?.value?.toLowerCase()?.trim() || '';
            if (!q) return USUARIOS;
            return USUARIOS.filter(u =>
            [u.first_name, u.last_name, u.email, u.document_number, u.phone]
                .filter(Boolean)
                .some(v => String(v).toLowerCase().includes(q))
            );
        }

        btn?.addEventListener('click', (e) => {
            e.stopPropagation();
            menu?.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!menu) return;
            const inside = menu.contains(e.target) || btn.contains(e.target);
            if (!inside) menu.classList.add('hidden');
        });
        document.getElementById('export-excel')?.addEventListener('click', () => {
            menu?.classList.add('hidden');
            const rows = buildExportRows(currentFilter());
            exportExcel(rows, 'usuarios.xlsx');
        });
        document.getElementById('export-pdf')?.addEventListener('click', () => {
            menu?.classList.add('hidden');
            const rows = buildExportRows(currentFilter());
            exportPDF(rows, 'usuarios.pdf');
        });
        }

        const usuarios = @json(($users instanceof \Illuminate\Pagination\AbstractPaginator) ? ($users->toArray()['data'] ?? []) : $users);
        const form = document.getElementById('formEditarUsuario');
        const btnActualizar = document.getElementById('btnActualizar');
        const camposRequeridos = ['first_name','last_name','email'];
        const camposEstudiante = ['academic_program_id','institution_id'];
        const camposEmpresa = ['company_name','company_address'];

        /**
         * Muestra un toast compacto en la esquina superior derecha.
         * @param {string} message Mensaje a mostrar; @param {'success'|'warning'|'error'} [type='success'] Tipo visual.
         * @returns {void} Inserta y remueve el toast automáticamente.
         */
        function showToast(message, type = 'success') {
        const wrap = document.createElement('div');
        wrap.className = `pointer-events-auto rounded-md px-4 py-3 shadow-lg text-sm ${type === 'success' ? 'bg-green-600 text-white' : (type === 'warning' ? 'bg-yellow-500 text-white' : 'bg-red-600 text-white')}`;
        wrap.style.whiteSpace = 'pre-line';
        wrap.textContent = message;
        (document.getElementById('toastContainer') || document.body).appendChild(wrap);
        setTimeout(() => wrap.remove(), 4500);
        }

        /**
         * Carga el usuario en el formulario y muestra la sección de edición.
         * @param {HTMLElement} btn Botón con data-user-id y data-update-url.
         * @returns {void} Pone valores, setea acción y dispara validación inicial.
         */
        function editarUsuario(btn) {
        const id = parseInt(btn.dataset.userId, 10);
        const updateUrl = btn.dataset.updateUrl;
        const user = Array.isArray(usuarios) ? usuarios.find(u => u.id === id) : null;
        if (!user) return showToast('⚠️ Usuario no encontrado', 'error');

        document.getElementById('tablaUsuarios').classList.add('hidden');
        document.getElementById('formularioEdicion').classList.remove('hidden');
        document.getElementById('mensajeBienvenida')?.classList.add('hidden');

        form.action = updateUrl;

        const allFields = [
            'first_name','last_name','email','birthdate','document_number','phone',
            'gender_id','document_type_id','user_type_id',
            'academic_program_id','institution_id',
            'company_name','company_address'
        ];
        allFields.forEach(field => {
            if (form[field] !== undefined) {
            let value = user[field] ?? '';
            if (field === 'birthdate' && value) {
                try { value = new Date(value).toISOString().split('T')[0]; } catch (e) {}
            }
            form[field].value = (value ?? '').toString();
            }
        });

        const currentRole = (user.roles && user.roles.length) ? (user.roles[0].name || user.roles[0]) : 'user';
        if (form['role']) form['role'].value = currentRole;

        toggleCamposEspeciales();
        validarFormulario();
        }

        /**
         * Cancela la edición y restaura la vista de tabla.
         * @param — Sin parámetros.
         * @returns {void} Limpia formulario y alterna visibilidad de secciones.
         */
        function cancelarEdicion() {
        form.reset();
        toggleCamposEspeciales();
        validarFormulario();
        document.getElementById('formularioEdicion').classList.add('hidden');
        document.getElementById('tablaUsuarios').classList.remove('hidden');
        document.getElementById('mensajeBienvenida')?.classList.remove('hidden');
        }

        /**
         * Muestra/oculta secciones según el tipo de usuario y limpia si no aplica.
         * @param — Sin parámetros (lee user_type_id del form).
         * @returns {void} Alterna #academic_section y #empresa_section y resetea.
         */
        function toggleCamposEspeciales() {
        const tipo = parseInt(form['user_type_id']?.value || '0');
        const academic = document.getElementById('academic_section');
        const empresa  = document.getElementById('empresa_section');

        if (academic) academic.classList.toggle('hidden', tipo !== 4);
        if (empresa)  empresa.classList.toggle('hidden', !(tipo === 2 || tipo === 3));

        if (tipo !== 4) {
            if (form['academic_program_id']) form['academic_program_id'].value = '';
            if (form['institution_id']) form['institution_id'].value = '';
        }
        if (!(tipo === 2 || tipo === 3)) {
            if (form['company_name']) form['company_name'].value = '';
            if (form['company_address']) form['company_address'].value = '';
        }
        }

        /**
         * Valida campos base y dinámicos para habilitar el botón de envío.
         * @param — Sin parámetros (usa el form y constantes globales).
         * @returns {void} Activa/desactiva el botón según validez.
         */
        function validarFormulario() {
        let esValido = true;

        camposRequeridos.forEach(id => {
            const el = form[id];
            if (!el || el.value.trim() === '') esValido = false;
        });

        const tipo = parseInt(form['user_type_id']?.value || '0');
        if (tipo === 4) {
            camposEstudiante.forEach(id => { if (!form[id]?.value.trim()) esValido = false; });
        }
        if (tipo === 2 || tipo === 3) {
            camposEmpresa.forEach(id => { if (!form[id]?.value.trim()) esValido = false; });
        }

        btnActualizar.disabled = !esValido;
        btnActualizar.classList.toggle('opacity-50', !esValido);
        btnActualizar.classList.toggle('cursor-not-allowed', !esValido);
        }

        /**
         * Registra listeners de inputs y gestiona el envío del formulario.
         * @param — Se ejecuta si existe el formulario en el DOM.
         * @returns {void} Adjunta eventos de cambio y submit con Axios.
         */
        if (form) {
        form.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', validarFormulario);
            el.addEventListener('change', () => { toggleCamposEspeciales(); validarFormulario(); });
        });

        /**
         * Envía el formulario por Axios y muestra toasts según respuesta.
         * @param {SubmitEvent} e Evento de envío del formulario.
         * @returns {Promise<void>} Maneja success/422/403/otros errores.
         */
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            formData.set('_method', 'PUT');
            formData.set('accepted_terms', 1);

            try {
            await axios.post(form.action, formData, { headers: { 'Accept': 'application/json' } });
            showToast('✅ Usuario actualizado correctamente', 'success');
            setTimeout(() => window.location.reload(), 900);
            } catch (error) {
            if (error.response && error.response.status === 422) {
                const errs = error.response.data.errors || {};
                const listado = Object.values(errs).flat().map(m => `• ${m}`).join('\n');
                showToast('Errores de validación:\n' + listado, 'error');
            } else if (error.response && error.response.status === 403) {
                showToast(error.response.data?.message || 'Acción no permitida.', 'error');
            } else {
                showToast('❌ Error al actualizar el usuario.', 'error');
            }
            }
        });
        }
    </script>
@endpush
