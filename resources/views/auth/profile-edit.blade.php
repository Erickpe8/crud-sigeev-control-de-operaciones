@extends('layouts.panel')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    @php
        // Determina a qué panel regresar al cancelar (admin o superadmin)
        $scope = auth()->user()->hasRole('superadmin') ? 'superadmin' : 'admin';
    @endphp

    {{-- Contenedor para toasts --}}
    <div id="toast-root" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none"></div>

    {{-- Formulario AJAX para editar mi perfil --}}
    <form id="editProfileForm"
          class="w-[720px] mx-auto bg-white rounded-lg shadow-lg p-6 relative"
          action="{{ route('profile.update', auth()->user()->id) }}"
          method="POST" enctype="multipart/form-data">
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
                <input type="text" id="last_name" name="last_name"
                       value="{{ old('last_name', auth()->user()->last_name) }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="Apellidos">
            </div>
            <div class="md:col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
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
                <label for="document_number" class="block mb-2 text-sm font-medium text-gray-900">Número de Documento</label>
                <input type="text" id="document_number" name="document_number"
                       value="{{ old('document_number', auth()->user()->document_number) }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="1234567890">
            </div>
        </div>

        {{-- Secciones condicionales (estudiante / empresa) --}}
        <div id="academic_section" class="grid gap-4 mb-6 md:grid-cols-2 hidden">
            <div>
                <label for="academic_program_id" class="block mb-2 text-sm font-medium text-gray-900">Programa Académico</label>
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
                <label for="company_address" class="block mb-2 text-sm font-medium text-gray-900">Dirección de la Empresa</label>
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
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone', auth()->user()->phone) }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="3101234567">
            </div>
            <div>
                <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900">Fecha de Nacimiento</label>
                <input type="text" id="birthdate" name="birthdate"
                       value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') : '') }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                       placeholder="dd/mm/aaaa">
            </div>
        </div>

        {{-- Foto de perfil --}}
        <div class="mb-6">
            <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Foto de Perfil</label>
            <div class="flex items-center gap-4">
                <input type="file" id="photo" name="photo"
                       accept="image/png,image/jpeg,image/jpg,image/webp"
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
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirmar Contraseña</label>
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
        // ====== Helper Toast ======
        // type: 'success' | 'error'
        function showToast(type, message, opts = {}) {
            const timeout = Number.isFinite(opts.timeout) ? opts.timeout : 4000;
            const root = document.getElementById('toast-root');
            if (!root) return;

            const palette = {
                success: 'bg-green-50 border-green-300 text-green-800',
                error: 'bg-red-50 border-red-300 text-red-800'
            };
            const base = palette[type] || palette.success;
            const el = document.createElement('div');
            el.className = `pointer-events-auto w-[360px] max-w-[92vw] rounded-lg border p-3 shadow-lg ${base} transition-all duration-200 opacity-0 translate-y-[-6px]`;
            el.innerHTML = `
                <div class="flex gap-3 items-start">
                    <div class="text-sm leading-5">${message}</div>
                    <button type="button" class="ml-auto p-1 rounded hover:bg-black/5 focus:outline-none" aria-label="Cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            el.querySelector('button').addEventListener('click', () => closeToast(el));
            root.appendChild(el);
            requestAnimationFrame(() => {
                el.classList.remove('opacity-0', 'translate-y-[-6px]');
                el.classList.add('opacity-100', 'translate-y-0');
            });
            if (timeout > 0) setTimeout(() => closeToast(el), timeout);
            function closeToast(node) {
                node.classList.remove('opacity-100', 'translate-y-0');
                node.classList.add('opacity-0', 'translate-y-[-6px]');
                setTimeout(() => node.remove(), 200);
            }
        }

        // ====== Configuración inicial ======
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('editProfileForm');
            const btn = document.getElementById('btnUpdate');
            const inputs = form.querySelectorAll('input[name], select[name]');
            const initial = {};

            // Captura valores iniciales para luego comparar
            inputs.forEach(el => {
                if (el.type === 'file') {
                    initial[el.name] = null;
                } else {
                    initial[el.name] = el.value;
                }
            });

            // Muestra/oculta secciones según el tipo de usuario
            function toggleSections() {
                const tipo = parseInt(document.getElementById('user_type_id').value);
                document.getElementById('academic_section').classList.toggle('hidden', tipo !== 4);
                document.getElementById('empresa_section').classList.toggle('hidden', !(tipo === 2 || tipo === 3));
            }
            toggleSections();
            document.getElementById('user_type_id').addEventListener('change', toggleSections);

            // Validación mínima para habilitar/deshabilitar el botón
            function checkForm() {
                let valid = true;
                // campos obligatorios (puedes ampliar esta lista según tus reglas)
                const requiredFields = ['first_name','last_name','email'];
                requiredFields.forEach(name => {
                    const el = form.querySelector(`[name="${name}"]`);
                    if (el && !el.value.trim()) valid = false;
                });
                // si el usuario ha escrito algo en password, comprobar confirmación
                const pass = form['password'].value;
                const passConf = form['password_confirmation'].value;
                if (pass || passConf) {
                    if (pass.length < 8 || pass !== passConf) valid = false;
                }
                btn.disabled = !valid;
                btn.classList.toggle('opacity-50', !valid);
                btn.classList.toggle('cursor-not-allowed', !valid);
            }
            checkForm();
            // Solo validar al cambiar (no al teclear)
            inputs.forEach(el => {
                el.addEventListener('change', checkForm);
                el.addEventListener('blur', checkForm);
            });

            // Manejo del envío
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                checkForm();
                if (btn.disabled) {
                    showToast('error', 'Completa los campos requeridos.');
                    return;
                }

                // Construye FormData solo con campos modificados
                let fd = new FormData();
                let cambios = 0;
                inputs.forEach(el => {
                    const name = el.name;
                    if (!name) return;
                    // Si es file: incluir siempre si hay un archivo seleccionado
                    if (el.type === 'file') {
                        const file = el.files && el.files[0];
                        if (file) {
                            fd.append(name, file);
                            cambios++;
                        }
                        return;
                    }
                    // Checkbox remove_photo: solo incluir si está marcado
                    if (el.type === 'checkbox') {
                        if (el.checked) {
                            fd.append(name, el.value);
                            cambios++;
                        }
                        return;
                    }
                    // Texto / select: comparar con snapshot
                    const currentValue = el.value.trim();
                    const initialValue = initial[name] ?? '';
                    // normaliza nulos a vacío para comparar
                    if (currentValue !== initialValue) {
                        // Normaliza fecha dd/mm/aaaa a yyyy-mm-dd
                        if (name === 'birthdate' && currentValue.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
                            const [d,m,y] = currentValue.split('/');
                            fd.append(name, `${y}-${m}-${d}`);
                        } else {
                            fd.append(name, currentValue);
                        }
                        cambios++;
                    }
                });
                // Si no hay cambios, muestra mensaje y termina
                if (cambios === 0) {
                    showToast('success', 'No hay cambios para guardar.');
                    return;
                }
                // Asegura el método PUT
                fd.append('_method', 'PUT');
                // Botón en estado loading
                const originalText = btn.textContent;
                btn.disabled = true;
                btn.textContent = 'Actualizando…';
                btn.classList.add('opacity-75');

                try {
                    const url = form.getAttribute('action');
                    const response = await axios.post(url, fd, {
                        headers: { 'Accept': 'application/json' },
                        onUploadProgress: (event) => {
                            if (event.total) {
                                const percent = Math.round((event.loaded * 100) / event.total);
                                btn.textContent = `Actualizando… ${percent}%`;
                            }
                        }
                    });
                    const res = response.data;
                    const message = res?.message || 'Perfil actualizado correctamente.';
                    showToast('success', message);
                    // Actualiza snapshot con nuevos valores
                    fd.forEach((v, k) => {
                        if (k === '_method') return;
                        // Para birthdate, el valor vendrá como yyyy-mm-dd; actualiza snapshot para no volver a enviar
                        if (k === 'birthdate') {
                            const parts = String(v).split('-');
                            if (parts.length === 3) {
                                initial[k] = `${parts[2]}/${parts[1]}/${parts[0]}`;
                                form[k].value = initial[k];
                            }
                        } else if (k === 'photo') {
                            // Actualiza preview si se subió una nueva foto
                            const file = v;
                            if (file instanceof File) {
                                const reader = new FileReader();
                                reader.onload = e => {
                                    const img = document.getElementById('previewPhoto');
                                    if (img) img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                            // set snapshot to empty string to avoid repeated upload
                            initial[k] = '';
                        } else {
                            initial[k] = String(v);
                            form[k].value = String(v);
                        }
                    });
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data?.errors || {};
                        const flat = Object.values(errors).flat().map(m => `• ${m}`);
                        showToast('error', flat.slice(0, 3).join('<br>'), { timeout: 6000 });
                        // Pinta inline los campos con error
                        Object.entries(errors).forEach(([field, msgs]) => {
                            const el = form.querySelector(`[name="${field}"]`);
                            if (!el) return;
                            el.classList.add('ring-2', 'ring-red-400');
                            // Muestra label de error debajo
                            let label = document.createElement('div');
                            label.className = 'text-xs text-red-600 mt-1';
                            label.setAttribute('data-error-label', 'true');
                            label.textContent = msgs.join(' ');
                            // Si ya existe un label de error, elimínalo
                            const old = el.parentNode.querySelector('[data-error-label="true"]');
                            if (old) old.remove();
                            el.insertAdjacentElement('afterend', label);
                        });
                    } else {
                        console.error('Error inesperado:', error);
                        showToast('error', 'Ocurrió un error inesperado al actualizar.', { timeout: 6000 });
                    }
                } finally {
                    btn.disabled = false;
                    btn.textContent = originalText;
                    btn.classList.remove('opacity-75');
                }
            });
        });
    </script>
@endpush
