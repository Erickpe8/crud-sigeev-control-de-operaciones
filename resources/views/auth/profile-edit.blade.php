@extends('layouts.panel')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Axios por defecto: CSRF y JSON (imprescindible para 422/500 con errores en JSON)
        (function () {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.defaults.headers.common['Accept'] = 'application/json';
        })();
    </script>
@endpush

@section('content')
            @php
// Determina a qué panel regresar al cancelar (admin o superadmin)
$scope = auth()->user()->hasRole('superadmin') ? 'superadmin' : 'admin';
            @endphp

            {{-- Formulario AJAX para editar mi perfil --}}
            <form id="editProfileForm" class="w-[720px] mx-auto bg-white rounded-lg shadow-lg p-6 relative"
                action="{{ route('profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Cabecera decorativa --}}
                <div class="relative h-6 bg-[#ff0000] rounded-t-lg">
                    <svg class="absolute top-full left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                        <path fill="#ffffff" d="M0,0 C480,100 960,0 1440,100 L1440,0 L0,0 Z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold mt-6 mb-4 text-center text-gray-800">Editar mi Información</h2>

                {{-- Datos personales --}}
                <div class="grid gap-4 mb-6 md:grid-cols-2">
                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Nombres</label>
                        <input type="text" id="first_name" name="first_name"
                            value="{{ old('first_name', auth()->user()->first_name) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Nombres">
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Apellidos">
                    </div>
                    <div class="md:col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="ejemplo@correo.com">
                    </div>
                </div>

                {{-- Documento y tipo --}}
                <div class="grid gap-4 mb-6 md:grid-cols-3">
                    <div>
                        <label for="user_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Usuario</label>
                        <select id="user_type_id" name="user_type_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Selecciona</option>
                            @foreach ($userTypes as $type)
                                <option value="{{ $type->id }}" {{ auth()->user()->user_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="document_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Documento</label>
                        <select id="document_type_id" name="document_type_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Selecciona</option>
                            @foreach ($documentTypes as $doc)
                                <option value="{{ $doc->id }}" {{ auth()->user()->document_type_id == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="document_number" class="block mb-2 text-sm font-medium text-gray-900">Número de
                            Documento</label>
                        <input type="text" id="document_number" name="document_number"
                            value="{{ old('document_number', auth()->user()->document_number) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="1234567890">
                    </div>
                </div>

                {{-- Secciones condicionales (estudiante / empresa) --}}
                <div id="academic_section" class="grid gap-4 mb-6 md:grid-cols-2 hidden">
                    <div>
                        <label for="academic_program_id" class="block mb-2 text-sm font-medium text-gray-900">Programa
                            Académico</label>
                        <select id="academic_program_id" name="academic_program_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Selecciona</option>
                            @foreach ($academicPrograms as $program)
                                <option value="{{ $program->id }}" {{ old('academic_program_id', auth()->user()->academic_program_id) == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="institution_id" class="block mb-2 text-sm font-medium text-gray-900">Institución</label>
                        <select id="institution_id" name="institution_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Selecciona</option>
                            @foreach ($institutions as $inst)
                                <option value="{{ $inst->id }}" {{ old('institution_id', auth()->user()->institution_id) == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="empresa_section" class="grid gap-4 mb-6 md:grid-cols-2 hidden">
                    <div>
                        <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Empresa</label>
                        <input type="text" id="company_name" name="company_name"
                            value="{{ old('company_name', auth()->user()->company_name) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="company_address" class="block mb-2 text-sm font-medium text-gray-900">Dirección de la
                            Empresa</label>
                        <input type="text" id="company_address" name="company_address"
                            value="{{ old('company_address', auth()->user()->company_address) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                </div>

                {{-- Campos adicionales --}}
                <div class="grid gap-4 mb-6 md:grid-cols-3">
                    <div>
                        <label for="gender_id" class="block mb-2 text-sm font-medium text-gray-900">Sexo</label>
                        <select id="gender_id" name="gender_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Selecciona</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}" {{ auth()->user()->gender_id == $gender->id ? 'selected' : '' }}>
                                    {{ $gender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="3101234567">
                    </div>
                    <div>
                        <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900">
                            Fecha de Nacimiento
                        </label>
                        <input type="text" id="birthdate" name="birthdate" maxlength="10"
                            value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') : '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="dd/mm/aaaa"
                            autocomplete="off">
                    </div>
                </div>

                {{-- Foto de perfil --}}
                <div class="mb-6">
                    <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Foto de Perfil</label>
                    <div class="flex items-center gap-4">
                        <input type="file" id="photo" name="photo" accept="image/png,image/jpeg,image/jpg,image/webp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 flex-1">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto de Perfil"
                                class="h-24 w-24 rounded-full object-cover border" id="previewPhoto">
                        @endif
                    </div>
                    {{-- Opción para eliminar la foto actual --}}
                    @if(auth()->user()->profile_photo)
                        <div class="mt-2 flex items-center gap-2">
                            <input type="checkbox" id="remove_photo" name="remove_photo" value="1" class="h-4 w-4 text-red-600">
                            <label for="remove_photo" class="text-sm text-gray-700">Eliminar foto actual</label>
                        </div>
                    @endif
                </div>

                {{-- Restablecer contraseña --}}
                <div class="grid gap-4 mb-6 md:grid-cols-2">
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Nueva Contraseña</label>
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Nueva contraseña">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirmar
                            Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Confirmar nueva contraseña">
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex gap-4 mt-6">
                    <button type="submit" id="btnUpdate"
                        class="flex items-center justify-center gap-2 bg-[#ff0000] text-white px-6 py-2 rounded w-full opacity-50 cursor-not-allowed">
                        Actualizar Información
                    </button>
                    @php $dashUrl = route('dashboards.' . $scope); @endphp
                    <a href="{{ $dashUrl }}"
                        class="flex items-center justify-center gap-2 bg-gray-600 text-white px-6 py-2 rounded w-full">
                        Cancelar
                    </a>
                </div>

                {{-- Pie decorativo --}}
                <div class="relative h-6 mt-6 bg-[#ff0000] rounded-b-lg">
                    <svg class="absolute top-0 left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                        <path fill="#ffffff" d="M0,100 C480,0 960,100 1440,0 L1440,100 L0,100 Z" />
                    </svg>
                </div>
            </form>
@endsection

@push('scripts')
    <script>
        // ====== Alertas tipo banda sobrepuestas (global root en <body>) ======
        function getAlertRoot() {
            let root = document.getElementById('alert-root-global');
            if (!root) {
                root = document.createElement('div');
                root.id = 'alert-root-global';
                root.setAttribute('aria-live', 'polite');
                root.setAttribute('aria-atomic', 'true');
                root.className = "fixed top-16 right-4 z-[2147483647] w-[min(92vw,560px)] space-y-3 pointer-events-auto";
                root.style.isolation = 'isolate';
                document.body.appendChild(root);
            }
            return root;
        }

        function pushAlert(type = 'info', title = '', message = '', opts = {}) {
            const root = getAlertRoot();
            const PALETTES = {
                info: 'text-blue-800 border border-blue-300 rounded-lg bg-blue-50',
                success: 'text-green-800 border border-green-300 rounded-lg bg-green-50',
                error: 'text-red-800 border border-red-300 rounded-lg bg-red-50',
                warning: 'text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50',
                neutral: 'text-gray-800 border border-gray-300 rounded-lg bg-gray-50',
            };
            const cls = PALETTES[type] || PALETTES.info;
            const wrapper = document.createElement('div');
            wrapper.setAttribute('role', 'alert');
            wrapper.className = `flex items-start p-4 ${cls} shadow-lg rounded-lg`;
            const iconSvg = `
    <svg class="shrink-0 inline w-4 h-4 me-3 mt-0.5" aria-hidden="true"
         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>`;
            const closeBtn = `
    <button type="button" class="ml-auto ms-3 inline-flex items-center justify-center rounded p-1 hover:bg-black/5 focus:outline-none" aria-label="Cerrar alerta">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>`;
            wrapper.innerHTML = `${iconSvg}<span class="sr-only">Info</span><div class="text-sm leading-5">${title ? `<span class=\"font-medium\">${title}</span> ` : ''}<span class="inline">${message}</span></div>${closeBtn}`;
            wrapper.querySelector('button')?.addEventListener('click', () => wrapper.remove());
            wrapper.style.opacity = '0';
            wrapper.style.transform = 'translateY(-6px)';
            root.appendChild(wrapper);
            requestAnimationFrame(() => {
                wrapper.style.transition = 'opacity .2s ease, transform .2s ease';
                wrapper.style.opacity = '1';
                wrapper.style.transform = 'translateY(0)';
            });
            const timeout = Number.isFinite(opts.timeout) ? opts.timeout : 0;
            if (timeout > 0) setTimeout(() => {
                wrapper.style.opacity = '0';
                wrapper.style.transform = 'translateY(-6px)';
                setTimeout(() => wrapper.remove(), 200);
            }, timeout);
        }

        // ====== Lógica del formulario ======
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('editProfileForm');
            const btn = document.getElementById('btnUpdate');
            const inputs = form.querySelectorAll('input[name], select[name]');
            const initial = {};

            // Snapshot inicial
            inputs.forEach(el => {
                initial[el.name] = (el.type === 'file') ? null : el.value;
            });

            // Mostrar/ocultar secciones
            function toggleSections() {
                const tipo = parseInt(document.getElementById('user_type_id').value);
                document.getElementById('academic_section').classList.toggle('hidden', tipo !== 4);
                document.getElementById('empresa_section').classList.toggle('hidden', !(tipo === 2 || tipo === 3));
            }
            toggleSections();
            document.getElementById('user_type_id').addEventListener('change', toggleSections);

            // ====== Utilidades Fecha ======
            const birthInput = document.getElementById('birthdate');

            // Inserta "/" automático al escribir -> dd/mm/aaaa
            function maskDMY(v) {
                v = (v || '').replace(/\D/g, '').slice(0, 8); // 8 dígitos
                if (v.length >= 5) return v.slice(0, 2) + '/' + v.slice(2, 4) + '/' + v.slice(4);
                if (v.length >= 3) return v.slice(0, 2) + '/' + v.slice(2);
                return v;
            }

            // Parse estricto dd/mm/yyyy -> Date o null
            function parseDMYStrict(str) {
                if (!/^\d{2}\/\d{2}\/\d{4}$/.test(str)) return null;
                const [d, m, y] = str.split('/').map(n => parseInt(n, 10));
                if (m < 1 || m > 12) return null;
                const dt = new Date(y, m - 1, d);
                // Validar que JS no “corrigió” la fecha (30/02 -> 02/03)
                if (dt.getFullYear() !== y || (dt.getMonth() + 1) !== m || dt.getDate() !== d) return null;
                return dt;
            }

            function isFuture(dateObj) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                dateObj = new Date(dateObj.getTime());
                dateObj.setHours(0, 0, 0, 0);
                return dateObj.getTime() > today.getTime();
            }

            // Auto-máscara en escritura y pegado
            if (birthInput) {
                birthInput.setAttribute('maxlength', '10'); // dd/mm/aaaa
                birthInput.addEventListener('input', (e) => {
                    const cur = e.target.value;
                    const masked = maskDMY(cur);
                    if (cur !== masked) e.target.value = masked;
                });
                birthInput.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text');
                    e.target.value = maskDMY(text);
                });
                // Validación en blur: formato + no futura
                birthInput.addEventListener('blur', (e) => {
                    const val = e.target.value.trim();
                    if (!val) return;
                    const date = parseDMYStrict(val);
                    if (!date) {
                        pushAlert('error', 'Fecha inválida', 'Usa el formato dd/mm/aaaa.', { timeout: 5000 });
                        e.target.classList.add('ring-2', 'ring-red-400');
                        return;
                    }
                    if (isFuture(date)) {
                        pushAlert('error', 'Fecha inválida', 'La fecha de nacimiento no puede ser futura.', { timeout: 5000 });
                        e.target.value = '';
                        e.target.classList.add('ring-2', 'ring-red-400');
                        return;
                    }
                    e.target.classList.remove('ring-2', 'ring-red-400');
                });
                // Focus: limpiar marca de error visual
                birthInput.addEventListener('focus', (e) => {
                    e.target.classList.remove('ring-2', 'ring-red-400');
                });
            }

            // Validación mínima
            function checkForm() {
                let valid = true; const messages = [];
                ['first_name', 'last_name', 'email'].forEach(name => {
                    const el = form.querySelector(`[name="${name}"]`);
                    if (el && !el.value.trim()) valid = false;
                });
                // email
                const emailEl = form['email'];
                if (emailEl) {
                    const emailVal = emailEl.value.trim();
                    if (emailVal) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(emailVal)) { valid = false; messages.push('El correo electrónico no es válido.'); }
                    }
                }
                // birthdate dd/mm/aaaa no futura (usa el parser estricto)
                const birthEl = form['birthdate'];
                if (birthEl) {
                    const birthRaw = birthEl.value.trim();
                    if (birthRaw) {
                        const dt = parseDMYStrict(birthRaw);
                        if (!dt) { valid = false; messages.push('La fecha de nacimiento debe tener el formato dd/mm/aaaa.'); }
                        else if (isFuture(dt)) { valid = false; messages.push('La fecha de nacimiento no puede ser futura.'); }
                    }
                }
                // password
                const passEl = form['password'];
                const passConfEl = form['password_confirmation'];
                const pass = passEl ? passEl.value : '';
                const passConf = passConfEl ? passConfEl.value : '';
                if (pass || passConf) {
                    if (pass !== passConf) { valid = false; messages.push('Las contraseñas no coinciden.'); }
                    if (pass.length < 10 || pass.length > 100) { valid = false; messages.push('La contraseña debe tener entre 10 y 100 caracteres.'); }
                    const lower = /[a-z]/, special = /[!@#\?]/;
                    if (!lower.test(pass) || !special.test(pass)) { valid = false; messages.push('La contraseña debe contener una letra minúscula y un carácter especial (! @ # ?).'); }
                }

                btn.disabled = !valid;
                btn.classList.toggle('opacity-50', !valid);
                btn.classList.toggle('cursor-not-allowed', !valid);

                // Mensaje breve en cambios/blur
                if (!valid && messages.length && this && this.eventPhase) {
                    pushAlert('error', 'Error de validación', messages[0], { timeout: 6000 });
                }
                return valid;
            }
            checkForm();
            inputs.forEach(el => { el.addEventListener('change', checkForm); el.addEventListener('blur', checkForm); });

            // Envío
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Limpia errores previos
                form.querySelectorAll('[data-error-label="true"]').forEach(n => n.remove());
                form.querySelectorAll('.ring-red-400').forEach(n => n.classList.remove('ring-2', 'ring-red-400'));

                const validSubmit = checkForm();
                if (!validSubmit) return;

                // Construye FormData sólo con cambios
                const fd = new FormData();
                let cambios = 0;
                inputs.forEach(el => {
                    const name = el.name; if (!name) return;
                    if (el.type === 'file') {
                        const file = el.files && el.files[0];
                        if (file) { fd.append(name, file); cambios++; }
                        return;
                    }
                    if (el.type === 'checkbox') {
                        // Para checkboxes, solo si está activo.
                        if (el.checked) { fd.append(name, el.value); cambios++; }
                        return;
                    }
                    const val = el.value.trim();
                    const prev = initial[name] ?? '';
                    if (val !== prev) {
                        if (name === 'birthdate' && /^\d{2}\/\d{2}\/\d{4}$/.test(val)) {
                            const [d, m, y] = val.split('/');
                            fd.append(name, `${y}-${m}-${d}`); // normaliza a ISO para el backend
                        } else {
                            fd.append(name, val);
                        }
                        cambios++;
                    }
                });

                if (cambios === 0) { pushAlert('neutral', 'Sin cambios', 'No hay cambios para guardar.', { timeout: 4000 }); return; }

                fd.append('_method', 'PUT');

                // loading
                const originalText = btn.textContent;
                btn.disabled = true; btn.textContent = 'Actualizando…'; btn.classList.add('opacity-75');

                try {
                    const url = form.getAttribute('action');
                    const response = await axios.post(url, fd, {
                        headers: { 'Accept': 'application/json' },
                        onUploadProgress: (ev) => {
                            if (ev.total) {
                                const p = Math.round((ev.loaded * 100) / ev.total);
                                btn.textContent = `Actualizando… ${p}%`;
                            }
                        }
                    });
                    const res = response.data; const message = res?.message || 'Perfil actualizado correctamente.';
                    pushAlert('success', 'Actualizado', message, { timeout: 1800 });
                    setTimeout(() => { window.location.href = "{{ route('panel') }}"; }, 1500);

                    // Actualiza snapshot
                    fd.forEach((v, k) => {
                        if (k === '_method') return;
                        if (k === 'birthdate') {
                            const parts = String(v).split('-');
                            if (parts.length === 3) {
                                initial[k] = `${parts[2]}/${parts[1]}/${parts[0]}`;
                                if (form[k]) form[k].value = initial[k];
                            }
                        } else if (k === 'photo') {
                            const file = v; if (file instanceof File) {
                                const reader = new FileReader();
                                reader.onload = e => {
                                    const img = document.getElementById('previewPhoto');
                                    if (img) img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                            initial[k] = '';
                        } else {
                            initial[k] = String(v);
                            if (form[k]) form[k].value = String(v);
                        }
                    });
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data?.errors || {};
                        const flat = Object.values(errors).flat().map(m => `• ${m}`);
                        pushAlert('error', 'Revisa los campos', flat.slice(0, 3).join('<br>'), { timeout: 6500 });
                        Object.entries(errors).forEach(([field, msgs]) => {
                            const el = form.querySelector(`[name="${field}"]`); if (!el) return;
                            el.classList.add('ring-2', 'ring-red-400');
                            const label = document.createElement('div');
                            label.className = 'text-xs text-red-600 mt-1';
                            label.setAttribute('data-error-label', 'true');
                            label.textContent = msgs.join(' ');
                            const old = el.parentNode.querySelector('[data-error-label="true"]'); if (old) old.remove();
                            el.insertAdjacentElement('afterend', label);
                        });
                    } else if (error.response) {
                        const data = error.response.data || {}; let html = data.message || 'Ocurrió un error inesperado.';
                        if (data.error_id) { html += `<div class="text-xs mt-2 opacity-70">ID: ${data.error_id}</div>`; }
                        if (data.exception || data.error) {
                            const ex = data.exception || ''; const errMsg = data.error || '';
                            html += `<div class="text-xs mt-1 opacity-70">${ex} ${errMsg}</div>`;
                        }
                        pushAlert('error', 'Error', html, { timeout: 7000 });
                    } else {
                        console.error('Error inesperado:', error);
                        pushAlert('error', 'Error inesperado', 'Ocurrió un error inesperado al actualizar.', { timeout: 7000 });
                    }
                } finally {
                    btn.disabled = false; btn.textContent = originalText; btn.classList.remove('opacity-75');
                }
            });
        });
    </script>
@endpush

