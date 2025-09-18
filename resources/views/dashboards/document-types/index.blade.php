@extends('layouts.panel')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Catálogo: Document Types</h1>
            @role('admin|superadmin')
            <button id="btnNew" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">+ Nuevo</button>
            @endrole
        </div>

        <div class="mb-3">
            <input id="searchBox" type="text" placeholder="Buscar..."
                class="rounded-lg px-3 py-2 text-sm w-72 border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="export-table" class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr class="text-gray-600 uppercase text-xs tracking-wider">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Código</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Activo</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="tbody"></tbody>
            </table>
        </div>
    </div>

    {{-- Modal CRUD --}}
    <div id="crudModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-md p-5">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Nuevo</h3>
            <form id="frmResource">
                @csrf
                <input type="hidden" id="id">

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Código</label>
                    <input id="code" type="text" class="w-full rounded-lg border-gray-300">
                    <div class="text-xs text-red-600 mt-1 hidden" id="err_code"></div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <input id="name" type="text" class="w-full rounded-lg border-gray-300">
                    <div class="text-xs text-red-600 mt-1 hidden" id="err_name"></div>
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" id="is_active" class="rounded" checked>
                    <label for="is_active" class="text-sm">Activo</label>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="btnCancel" class="px-4 py-2 rounded-lg border">Cancelar</button>
                    <button type="submit" id="btnSave" class="px-4 py-2 rounded-lg bg-red-600 text-white">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        (function () {
            // === CSRF para Axios ===
            (function setupAxiosCsrf() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            })();

            // === Toast simple (mismo patrón) ===
            function showToast(message, type = 'success') {
                const wrap = document.createElement('div');
                wrap.className = `pointer-events-auto rounded-md px-4 py-3 shadow-lg text-sm ${type === 'success' ? 'bg-green-600 text-white' :
                        type === 'warning' ? 'bg-yellow-500 text-white' : 'bg-red-600 text-white'}`;
                wrap.style.whiteSpace = 'pre-line';
                wrap.textContent = message;
                (document.getElementById('toastContainer') || document.body).appendChild(wrap);
                setTimeout(() => wrap.remove(), 4500);
            }

            const $ = s => document.querySelector(s);
            const tbody = $('#tbody'), modal = $('#crudModal');
            const frm = $('#frmResource'), btnNew = $('#btnNew');
            const btnCancel = $('#btnCancel'), btnSave = $('#btnSave');
            const searchBox = $('#searchBox');

            let rows = [];

            function openModal(title, data) {
                $('#modalTitle').textContent = title;
                $('#id').value = data?.id || '';
                $('#code').value = data?.code || '';
                $('#name').value = data?.name || '';
                $('#is_active').checked = data?.is_active ?? true;
                clearErrors();
                modal.classList.remove('hidden');
                $('#code').focus();
            }
            function closeModal() { modal.classList.add('hidden'); }
            function clearErrors() {
                ['code', 'name'].forEach(k => {
                    const el = document.getElementById('err_' + k);
                    if (el) { el.textContent = ''; el.classList.add('hidden'); }
                });
            }

            function rowTpl(r) {
                return `
          <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-2">${r.id}</td>
            <td class="px-4 py-2">${r.code ?? ''}</td>
            <td class="px-4 py-2">${r.name ?? ''}</td>
            <td class="px-4 py-2">${r.is_active ? 'Sí' : 'No'}</td>
            <td class="px-4 py-2 text-center flex gap-2 justify-center">
              <button data-act="edit" data-id="${r.id}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Editar</button>
              <button data-act="del"  data-id="${r.id}" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Eliminar</button>
            </td>
          </tr>`;
            }

            async function load(q = '') {
                try {
                    const { data } = await axios.get(`{{ route('dashboard.document-types.list') }}`, { params: { q } });
                    rows = Array.isArray(data.data) ? data.data : [];
                    tbody.innerHTML = rows.map(rowTpl).join('');
                    initDataTable();
                } catch (e) {
                    showToast('No se pudo cargar el listado.', 'error');
                }
            }

            // simple-datatables
            function initDataTable() {
                const el = document.getElementById('export-table');
                if (!el || typeof simpleDatatables?.DataTable === 'undefined') return;
                if (el._dt) { el._dt.destroy(); el._dt = null; }
                const dt = new simpleDatatables.DataTable(el, {
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
                el._dt = dt;
            }

            // Buscar mientras escribe
            searchBox?.addEventListener('input', (e) => load(e.target.value.trim()));

            // Acciones en tabla: editar y eliminar
            tbody.addEventListener('click', async (e) => {
                const btn = e.target.closest('button'); if (!btn) return;
                const id = btn.dataset.id, act = btn.dataset.act;

                if (act === 'edit') {
                    const r = rows.find(x => String(x.id) === String(id));
                    openModal('Editar', r);
                }
                if (act === 'del') {
                    if (!confirm('¿Eliminar este registro?')) return;
                    try {
                        await axios.delete(`{{ url('/dashboard/document-types') }}/${id}`, { headers: { 'Accept': 'application/json' } });
                        showToast('Eliminado.');
                        load(searchBox.value.trim());
                    } catch (err) {
                        showToast(err.response?.data?.message || 'No se pudo eliminar.', 'error');
                    }
                }
            });

            // Nuevo
            btnNew?.addEventListener('click', () => openModal('Nuevo', null));
            btnCancel?.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

            // Guardar (crear/actualizar)
            frm.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearErrors();

                const id = $('#id').value;
                const payload = {
                    'code': ($('#code').value || '').trim(),
                    'name': ($('#name').value || '').trim(),
                    is_active: $('#is_active').checked ? 1 : 0
                };

                btnSave.disabled = true; btnSave.textContent = 'Guardando…';
                try {
                    let res;
                    if (id) {
                        res = await axios.put(`{{ url('/dashboard/document-types') }}/${id}`, payload, { headers: { 'Accept': 'application/json' } });
                    } else {
                        res = await axios.post(`{{ route('dashboard.document-types.store') }}`, payload, { headers: { 'Accept': 'application/json' } });
                    }
                    showToast(res.data?.message || 'Guardado.');
                    closeModal();
                    load(searchBox.value.trim());
                } catch (err) {
                    if (err.response?.status === 422) {
                        const errors = err.response.data?.errors || {};
                        if (errors['code']) {
                            const el = document.getElementById('err_code');
                            el.textContent = errors['code'].join(' ');
                            el.classList.remove('hidden');
                        }
                        if (errors['name']) {
                            const el = document.getElementById('err_name');
                            el.textContent = errors['name'].join(' ');
                            el.classList.remove('hidden');
                        }
                        showToast('Revisa los campos.', 'error');
                    } else {
                        showToast(err.response?.data?.message || 'Error inesperado.', 'error');
                    }
                } finally {
                    btnSave.disabled = false; btnSave.textContent = 'Guardar';
                }
            });

            // Cargar al inicio
            load();
        })();
    </script>
@endpush
