{{-- resources/views/users/index.blade.php --}}
@extends('layouts.panel')

@push('head')
      {{-- CSRF para Axios --}}
      <meta name="csrf-token" content="{{ csrf_token() }}">
      {{-- simple-datatables (CSS) --}}
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
      {{-- Toasts (arriba-derecha) --}}
      <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

      <div id="infoPanel" class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios</h1>

        {{-- Mensaje de bienvenida --}}
        <div id="mensajeBienvenida" class="bg-white p-4 shadow rounded mb-6">
          <p class="text-gray-700 leading-relaxed">
            Bienvenido, Administrador. Desde este panel puedes visualizar, editar y eliminar usuarios
            (excepto <strong>Superadministradores</strong>).
          </p>
        </div>

        {{-- Tabla + cabecera plugin --}}
        <div id="tablaUsuarios" class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table id="usuarios-table" class="min-w-full text-sm text-left">
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
              @forelse(($users ?? collect()) as $usuario)
                @php
    $isSuper = $usuario->hasRole('superadmin');
    $rolesStr = $usuario->roles->pluck('name')->implode(', ');
                @endphp
                <tr class="hover:bg-gray-50 transition" data-user-id="{{ $usuario->id }}">
                  <td class="px-4 py-2">{{ $usuario->id }}</td>
                  <td class="px-4 py-2">{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                  <td class="px-4 py-2">{{ $usuario->email }}</td>
                  <td class="px-4 py-2">
                    <span class="px-2 py-0.5 rounded text-xs {{ $isSuper ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                      {{ $rolesStr ?: 'sin rol' }}
                    </span>
                  </td>
                  <td class="px-4 py-2">
                    <div class="flex items-center justify-center gap-4">
                      @can('users.manage')
                        {{-- Editar inline (SPA) --}}
                        <button
                          data-user-id="{{ $usuario->id }}"
                          data-update-url="{{ route('usuarios.update', $usuario) }}"
                          onclick="editarUsuario(this)"
                          @if($isSuper) disabled title="No puedes editar a un Super Admin" @endif
                          class="px-4 py-1.5 text-sm font-medium text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-1 transition
                                 {{ $isSuper ? 'bg-blue-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-400' }}">
                          Editar
                        </button>
                      @endcan

                      @if(!$isSuper && auth()->user()->can('users.delete'))
                        {{-- Eliminar (confirmación) --}}
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Eliminar este usuario?')" class="flex-none">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="px-4 py-1.5 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1 transition">
                            Eliminar
                          </button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay usuarios para mostrar.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Formulario de edición inline (oculto hasta presionar Editar) --}}
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
    'phone' => 'Teléfono',
];
              @endphp

              @foreach ($camposTexto as $id => $label)
                <div>
                  <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                  <input
                    type="{{ $id === 'email' ? 'email' : ($id === 'birthdate' ? 'date' : 'text') }}"
                    id="{{ $id }}" name="{{ $id }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
              @endforeach

              @foreach ([
    'gender_id' => $genders ?? collect(),
    'document_type_id' => $documentTypes ?? collect(),
    'user_type_id' => $userTypes ?? collect(),
] as $id => $collection)
                    <div>
                      <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $id)) }}</label>
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

              {{-- Dinámicos: Estudiante --}}
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

              {{-- Dinámicos: Empresa --}}
              <div id="empresa_section" class="col-span-2 hidden">
                <div class="mb-4">
                  <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
                  <input type="text" id="company_name" name="company_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                  <label for="company_address" class="block text-sm font-medium text-gray-700">Dirección de la Empresa</label>
                  <input type="text" id="company_address" name="company_address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
              </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 md:justify-end">
              <button type="submit" id="btnActualizar" disabled
                      class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded opacity-50 cursor-not-allowed">
                Actualizar
              </button>
              <button type="button" onclick="cancelarEdicion()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
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
       * Configura CSRF en Axios y, si ?debug=1, añade interceptores de log.
       * @param — sin parámetros (IIFE autoejecutable).
       * @returns {void} No devuelve valor; solo configura axios.
       */
      (function setupAxios() {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

        const debug = new URLSearchParams(location.search).get('debug') === '1';
        if (!debug) return;

        axios.interceptors.request.use(cfg => {
          try {
            console.groupCollapsed('%c[REQ]', 'color:#2563eb', cfg.method?.toUpperCase(), cfg.url);
            if (cfg.data instanceof FormData) {
              const obj = {}; for (const [k,v] of cfg.data.entries()) obj[k] = v; console.log('FormData →', obj);
            } else { console.log('Payload →', cfg.data); }
          } finally { console.groupEnd(); }
          return cfg;
        });
        axios.interceptors.response.use(
          res => { console.log('[RES OK]', res.status, res.config?.url, res.data); return res; },
          err => { console.warn('[RES ERR]', err?.response?.status, err?.config?.url, err?.response?.data); return Promise.reject(err); }
        );
      })();

      const GENDERS_MAP   = @json(($genders ?? collect())->pluck('name', 'id'));
      const DOC_TYPES_MAP = @json(($documentTypes ?? collect())->mapWithKeys(fn($d) => [$d->id => ($d->name ?? $d->type ?? '')]));
      const USUARIOS = @json($users);

      /**
       * Muestra un toast sencillo en la esquina superior derecha.
       * @param {string} message Texto a mostrar; @param {'success'|'warning'|'error'} [type='success'] tipo visual.
       * @returns {void} Inserta el toast y lo remueve automáticamente.
       */
      function showToast(message, type = 'success') {
        const wrap = document.createElement('div');
        wrap.className = `pointer-events-auto rounded-md px-4 py-3 shadow-lg text-sm ${type==='success'?'bg-green-600 text-white':type==='warning'?'bg-yellow-500 text-white':'bg-red-600 text-white'}`;
        wrap.style.whiteSpace = 'pre-line';
        wrap.textContent = message;
        (document.getElementById('toastContainer')||document.body).appendChild(wrap);
        setTimeout(()=>wrap.remove(), 4500);
      }

      /**
       * Marca un campo con error y muestra/oculta el mensaje asociado.
       * @param {string} id ID del input/select; @param {string} [msg=''] Mensaje de error o vacío para limpiar.
       * @returns {void} Ajusta clases, aria-invalid y el help text.
       */
      function setFieldError(id, msg='') {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('ring-2', !!msg);
        el.classList.toggle('ring-red-500', !!msg);
        el.setAttribute('aria-invalid', msg ? 'true' : 'false');
        const sel = `[data-error-for="${id}"]`;
        let help = el.parentElement.querySelector(sel);
        if (!help && msg) {
          help = document.createElement('p');
          help.className = 'mt-1 text-xs text-red-600';
          help.setAttribute('data-error-for', id);
          el.parentElement.appendChild(help);
        }
        if (help) { help.textContent = msg; if (!msg) help.remove(); }
      }

      /**
       * Convierte una fecha ISO a cadena dd/mm/yyyy.
       * @param {string} iso Fecha ISO o similar.
       * @returns {string} Fecha formateada dd/mm/yyyy o cadena original si falla.
       */
      function formatDateISOtoDMY(iso) {
        if (!iso) return '';
        try {
          const parts = String(iso).split('T')[0].split('-');
          if (parts.length === 3) { const [y,m,d] = parts; return `${d.padStart(2,'0')}/${m.padStart(2,'0')}/${y}`; }
          const d = new Date(iso); if (isNaN(d.getTime())) return iso;
          const dd = String(d.getUTCDate()).padStart(2,'0');
          const mm = String(d.getUTCMonth()+1).padStart(2,'0');
          const yyyy = d.getUTCFullYear();
          return `${dd}/${mm}/${yyyy}`;
        } catch { return iso; }
      }

      /**
       * Construye filas planas para exportar desde el dataset de usuarios.
       * @param {Array<Object>} source Arreglo de usuarios.
       * @returns {Array<Object>} Filas con claves legibles para Excel/PDF.
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
       * Exporta a Excel usando SheetJS a partir de filas JSON.
       * @param {Array<Object>} rows Filas a exportar; @param {string} [fileName='usuarios.xlsx'] nombre del archivo.
       * @returns {void} Descarga el archivo xlsx en el navegador.
       */
      function exportExcel(rows, fileName = 'usuarios.xlsx') {
        if (!rows?.length) return alert('No hay datos para exportar.');
        const ws = XLSX.utils.json_to_sheet(rows, { header: Object.keys(rows[0]) });
        ws['!cols'] = Object.keys(rows[0]).map(k => ({ wch: Math.max(k.length, ...rows.map(r => String(r[k] ?? '').length)) + 2 }));
        const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, 'Usuarios'); XLSX.writeFile(wb, fileName);
      }

      /**
       * Exporta a PDF con jsPDF + autoTable.
       * @param {Array<Object>} rows Filas a exportar; @param {string} [fileName='usuarios.pdf'] nombre del archivo.
       * @returns {void} Descarga el archivo pdf en el navegador.
       */
      function exportPDF(rows, fileName = 'usuarios.pdf') {
        if (!rows?.length) return alert('No hay datos para exportar.');
        const { jsPDF } = window.jspdf || {};
        const hasJsPDF = typeof jsPDF === 'function';
        const hasAutoTable = !!(jsPDF && jsPDF.API && typeof jsPDF.API.autoTable === 'function');
        if (!hasJsPDF || !hasAutoTable) { alert('Librerías de PDF no disponibles.'); return; }
        const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'A4' });
        const headers = [Object.keys(rows[0])];
        const body = rows.map(r => headers[0].map(h => r[h] ?? ''));
        doc.setFontSize(12); doc.text('Usuarios', 40, 40);
        doc.autoTable({ startY: 60, head: headers, body, styles: { fontSize: 9, cellPadding: 4, overflow: 'linebreak' }, headStyles: { fillColor: [41,98,255], textColor: 255 }, margin: { left: 40, right: 40 }, tableWidth: 'auto' });
        doc.save(fileName);
      }

      let datatable = null;
      if (document.getElementById('usuarios-table') && typeof simpleDatatables?.DataTable !== 'undefined') {
        /**
         * Inicializa la tabla con simple-datatables y UI de exportación/búsqueda.
         * @param — sin parámetros (invocación directa si existe #usuarios-table).
         * @returns {void} Configura plantilla, labels y paginación.
         */
        datatable = new simpleDatatables.DataTable('#usuarios-table', {
          template: (options, dom) =>
            "<div class='" + options.classes.top + "'>" +
              "<div class='flex flex-row items-center justify-between gap-4'>" +
                (options.paging && options.perPageSelect
                  ? "<div class='flex items-center gap-2'>" +
                    "<label class='flex items-center gap-2'>" +
                      "<select class='" + options.classes.selector + " border-gray-300 rounded-md'></select>" +
                      "<span class='text-sm text-gray-600'>por página</span>" +
                    "</label></div>" : "" ) +
                "<div class='relative'>" +
                  "<button id='exportDropdownButton' type='button' class='flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none'>Exportar" +
                    "<svg class='ml-1 h-4 w-4' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7'/></svg>" +
                  "</button>" +
                  "<div id='exportDropdown' class='absolute right-0 mt-2 z-10 hidden w-48 rounded-lg bg-white shadow-sm ring-1 ring-black/5'>" +
                    "<ul class='p-2 text-sm text-gray-700' aria-labelledby='exportDropdownButton'>" +
                      "<li><button id='export-excel' class='w-full px-3 py-2 text-left hover:bg-gray-100'>Exportar a Excel</button></li>" +
                      "<li><button id='export-pdf'   class='w-full px-3 py-2 text-left hover:bg-gray-100'>Exportar a PDF</button></li>" +
                    "</ul></div></div>" +
                (options.searchable
                  ? "<div class='" + options.classes.search + " w-64'>" +
                    "<input class='" + options.classes.input + " w-full rounded-md border-gray-300' placeholder='Buscar…' type='search' title='Buscar en la tabla' " + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
                    "</div>" : "" ) +
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
            placeholder: 'Buscar…', perPage: 'por página',
            noRows: 'No se encontraron registros',
            info: 'Mostrando {start}–{end} de {rows}', searchTitle: 'Buscar en la tabla'
          }
        });

        /**
         * Ajusta el selector de filas por página y fuerza 100 por defecto.
         * @param — evento interno datatable.init.
         * @returns {void} Reemplaza opciones y dispara change.
         */
        datatable.on('datatable.init', () => {
          const selector = datatable.wrapper?.querySelector('select.dataTable-selector');
          if (!selector) return;
          const desired = ['50','100','200'];
          const current  = Array.from(selector.options).map(o => o.value);
          if (desired.join(',') !== current.join(',')) {
            selector.innerHTML = '';
            desired.forEach(v => { const opt = document.createElement('option'); opt.value = v; opt.textContent = v; selector.appendChild(opt); });
          }
          selector.value = '100'; selector.dispatchEvent(new Event('change'));
        });

        const btn = document.getElementById('exportDropdownButton');
        const menu = document.getElementById('exportDropdown');

        /**
         * Devuelve el dataset filtrado según el término de búsqueda.
         * @param — sin parámetros (lee el input de simple-datatables).
         * @returns {Array<Object>} Conjunto filtrado de usuarios.
         */
        function currentFilter() {
          const q = datatable?.input?.value?.toLowerCase()?.trim() || '';
          if (!q) return USUARIOS;
          return USUARIOS.filter(u =>
            [u.first_name, u.last_name, u.email, u.document_number, u.phone]
              .filter(Boolean)
              .some(v => String(v).toLowerCase().includes(q))
          );
        }

        btn?.addEventListener('click', (e) => { e.stopPropagation(); menu?.classList.toggle('hidden'); });
        document.addEventListener('click', (e) => {
          if (!menu) return; const inside = menu.contains(e.target) || btn.contains(e.target);
          if (!inside) menu.classList.add('hidden');
        });

        document.getElementById('export-excel')?.addEventListener('click', () => {
          menu?.classList.add('hidden'); exportExcel(buildExportRows(currentFilter()), 'usuarios.xlsx');
        });
        document.getElementById('export-pdf')?.addEventListener('click', () => {
          menu?.classList.add('hidden'); exportPDF(buildExportRows(currentFilter()), 'usuarios.pdf');
        });
      }

      const usuarios      = @json($users);
      const form          = document.getElementById('formEditarUsuario');
      const btnActualizar = document.getElementById('btnActualizar');

      const camposRequeridosBase = ['first_name','last_name','email'];
      const camposEstudiante     = ['academic_program_id','institution_id'];
      const camposEmpresa        = ['company_name','company_address'];

      let prevUserType = null;

      /**
       * Abre el formulario de edición, carga valores y prepara validaciones.
       * @param {HTMLElement} btnEl Botón que dispara la edición (con data-user-id y data-update-url).
       * @returns {void} No devuelve valor; actualiza UI y form.action.
       */
      function editarUsuario(btnEl) {
        const id        = parseInt(btnEl.dataset.userId, 10);
        const updateUrl = btnEl.dataset.updateUrl;
        const user      = Array.isArray(usuarios) ? usuarios.find(u => u.id === id) : null;
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
              try { value = new Date(value).toISOString().split('T')[0]; } catch(e){}
            }
            form[field].value = (value ?? '').toString();
            setFieldError(field, '');
          }
        });

        form.querySelectorAll('input,select,textarea').forEach(el => el.disabled = false);

        prevUserType = parseInt(form['user_type_id']?.value || '0', 10);
        toggleCamposEspeciales(true);
        validarFormulario();
      }

      /**
       * Cancela la edición y restablece la vista inicial.
       * @param — sin parámetros.
       * @returns {void} Limpia errores, oculta formulario y muestra tabla.
       */
      function cancelarEdicion() {
        form.reset();
        form.querySelectorAll('input,select,textarea').forEach(el => setFieldError(el.id || el.name, ''));
        toggleCamposEspeciales();
        validarFormulario();
        document.getElementById('formularioEdicion').classList.add('hidden');
        document.getElementById('tablaUsuarios').classList.remove('hidden');
        document.getElementById('mensajeBienvenida')?.classList.remove('hidden');
      }

      /**
       * Alterna secciones dinámicas según tipo de usuario y limpia al salir.
       * @param {boolean} [force=false] Fuerza evaluación aunque no cambie el tipo previo.
       * @returns {void} Ajusta visibilidad y requeridos, y limpia campos si cambia.
       */
      function toggleCamposEspeciales(force = false) {
        const tipo = parseInt(form['user_type_id']?.value || '0', 10);
        if (!force && prevUserType === tipo) return;

        const academic = document.getElementById('academic_section');
        const empresa  = document.getElementById('empresa_section');

        const isEst = (tipo === 4);
        const isEmp = (tipo === 2 || tipo === 3);

        if (academic) academic.classList.toggle('hidden', !isEst);
        if (empresa)  empresa.classList.toggle('hidden', !isEmp);

        ['academic_program_id','institution_id'].forEach(id => { const el = form[id]; if (el) el.required = isEst; });
        ['company_name','company_address'].forEach(id => { const el = form[id]; if (el) el.required = isEmp; });

        const wasEst = (prevUserType === 4);
        const wasEmp = (prevUserType === 2 || prevUserType === 3);

        if (!isEst && wasEst) {
          if (form['academic_program_id']) form['academic_program_id'].value = '';
          if (form['institution_id'])      form['institution_id'].value      = '';
          setFieldError('academic_program_id',''); setFieldError('institution_id','');
        }
        if (!isEmp && wasEmp) {
          if (form['company_name'])    form['company_name'].value    = '';
          if (form['company_address']) form['company_address'].value = '';
          setFieldError('company_name',''); setFieldError('company_address','');
        }

        prevUserType = tipo;
      }

      /**
       * Valida campos base, email, secciones dinámicas y teléfono.
       * @param — sin parámetros (lee desde el form global).
       * @returns {boolean} True si el formulario está OK; false si hay errores.
       */
      function validarFormulario() {
        let ok = true;

        camposRequeridosBase.forEach(id => {
          const el = form[id]; if (!el) return;
          const v = (el.value || '').trim();
          const valid = v.length > 0;
          if (!valid) ok = false;
          setFieldError(id, valid ? '' : 'Campo obligatorio');
        });

        if (form.email) {
          const val = form.email.value.trim();
          const em  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
          if (!em) { ok = false; setFieldError('email', 'Correo no válido'); }
        }

        const tipo = parseInt(form['user_type_id']?.value || '0', 10);
        if (tipo === 4) {
          ['academic_program_id','institution_id'].forEach(id => {
            const el = form[id]; if (!el) return;
            const v = (el.value || '').trim(); const valid = v.length > 0;
            if (!valid) ok = false; setFieldError(id, valid ? '' : 'Obligatorio para estudiantes');
          });
        }
        if (tipo === 2 || tipo === 3) {
          ['company_name','company_address'].forEach(id => {
            const el = form[id]; if (!el) return;
            const v = (el.value || '').trim(); const valid = v.length > 0;
            if (!valid) ok = false; setFieldError(id, valid ? '' : 'Obligatorio para empresas');
          });
        }

        if (form.phone && form.phone.value) {
          const phOk = /^[0-9+\-\s()]{7,25}$/.test(form.phone.value.trim());
          if (!phOk) { ok = false; setFieldError('phone', 'Formato de teléfono inválido'); }
          else setFieldError('phone', '');
        }

        btnActualizar.disabled = !ok;
        btnActualizar.classList.toggle('opacity-50', !ok);
        btnActualizar.classList.toggle('cursor-not-allowed', !ok);
        return ok;
      }

      /**
       * Cablea listeners de inputs y submit para validación y envío.
       * @param — sin parámetros (IIFE autoejecutable).
       * @returns {void} Agrega eventos, valida y hace POST via Axios.
       */
      (function wireForm() {
        if (!form) return;
        form.querySelectorAll('input, select, textarea').forEach(el => {
          el.addEventListener('input', validarFormulario);
          el.addEventListener('change', (e) => {
            if (e.target.name === 'user_type_id') toggleCamposEspeciales();
            validarFormulario();
          });
        });

        form.addEventListener('submit', async function (e) {
          e.preventDefault();
          if (!validarFormulario()) { showToast('Revisa los campos marcados en rojo.', 'warning'); return; }

          const fd = new FormData(form);
          fd.set('_method', 'PUT');
          fd.set('accepted_terms', 1);

          try {
            fd.append('_method', 'PUT');
            await axios.post(form.action, fd, { headers: { 'Accept': 'application/json' } });
            showToast('✅ Usuario actualizado correctamente', 'success');
            setTimeout(() => window.location.reload(), 900);
          } catch (error) {
            if (error?.response?.status === 422) {
              const errs = error.response.data.errors || {};
              Object.entries(errs).forEach(([field, msgs]) => setFieldError(field, msgs?.[0] || 'Inválido'));
              const listado = Object.values(errs).flat().map(m => `• ${m}`).join('\n');
              showToast('Errores de validación:\n' + listado, 'error');
            } else if (error?.response?.status === 403) {
              showToast(error.response.data?.message || 'Acción no permitida.', 'error');
            } else {
              showToast('❌ Error al actualizar el usuario.', 'error');
            }
          }
        });
      })();
      </script>
@endpush
