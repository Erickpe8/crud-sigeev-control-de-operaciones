{{-- resources/views/users/create.blade.php --}}
@extends('layouts.panel')

@push('head')
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Axios CDN si no lo tienes ya en tu app.js --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    @php
        // Detecta el panel actual para construir las rutas
        $scope = auth()->user()->hasRole('superadmin') ? 'superadmin' : 'admin';
    @endphp

    <form id="adminCreateForm" class="w-[720px] mx-auto bg-white rounded-lg shadow-lg p-6 relative">
        <!-- Cabecera decorativa -->
        <div class="relative h-6 bg-[#ff0000] rounded-t-lg">
            <svg class="absolute top-full left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,0 C480,100 960,0 1440,100 L1440,0 L0,0 Z"></path>
            </svg>
        </div>

        <h2 class="text-2xl font-bold mt-6 mb-4 text-center text-gray-800">Registrar Nuevo Usuario</h2>

        <!-- Datos personales -->
        <div class="grid gap-4 mb-6 md:grid-cols-2">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Nombres</label>
                <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nombres">
            </div>
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
                <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Apellidos">
            </div>
            <div class="md:col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="ejemplo@correo.com">
            </div>
        </div>

        <!-- Documento y tipo -->
        <div class="grid gap-4 mb-6 md:grid-cols-3">
            <div>
                <label for="user_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Usuario</label>
                <select id="user_type_id" onchange="toggleCamposEspeciales()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona</option>
                    @foreach ($userTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="document_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Documento</label>
                <select id="document_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona</option>
                    @foreach ($documentTypes as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="document_number" class="block mb-2 text-sm font-medium text-gray-900">Número de
                    Documento</label>
                <input type="text" id="document_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1234567890">
            </div>
        </div>

        <!-- Campos adicionales -->
        <div class="grid gap-4 mb-6 md:grid-cols-3">
            <div>
                <label for="gender_id" class="block mb-2 text-sm font-medium text-gray-900">Sexo</label>
                <select id="gender_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
                <input type="text" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="3101234567">
            </div>
            <div>
                <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900">Fecha de Nacimiento</label>
                <input type="date" id="birthdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
        </div>

        <!-- Rol inicial (solo visible para superadmin) -->
        @if(isset($roles) && $roles->count())
            <div class="grid gap-4 mb-6 md:grid-cols-3">
                <div class="md:col-span-3">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">¿Deseas asignarle un rol?</label>
                    <select id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                        focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">(Por defecto: user)</option>
                        @foreach ($roles as $r)
                            @if($r !== 'user')
                                <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                            @endif
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Si no eliges, se asigna <b>user</b>.</p>
                </div>
            </div>
        @endif

        <!-- Campos académicos -->
        <div id="academic_section" class="grid gap-4 mb-6 md:grid-cols-2 hidden">
            <div>
                <label for="academic_program_id" class="block mb-2 text-sm font-medium text-gray-900">Programa
                    Académico</label>
                <select id="academic_program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona</option>
                    @foreach ($academicPrograms as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="institution_id" class="block mb-2 text-sm font-medium text-gray-900">Institución</label>
                <select id="institution_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona</option>
                    @foreach ($institutions as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Campos empresariales -->
        <div id="empresa_section" class="grid gap-4 mb-6 md:grid-cols-2 hidden">
            <div>
                <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la Empresa</label>
                <input type="text" id="company_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <div>
                <label for="company_address" class="block mb-2 text-sm font-medium text-gray-900">Dirección de la
                    Empresa</label>
                <input type="text" id="company_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
        </div>

        <!-- Contraseñas -->
        <div class="grid gap-4 mb-6 md:grid-cols-2">
            <div class="relative">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10">
                <button type="button" onclick="togglePassword('password', this)"
                    class="absolute right-3 top-9 text-gray-500">👁</button>
            </div>
            <div class="relative">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirmar
                    Contraseña</label>
                <input type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10">
                <button type="button" onclick="togglePassword('password_confirmation', this)"
                    class="absolute right-3 top-9 text-gray-500">👁</button>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-6">
            <button type="button" id="btnCrear" disabled onclick="crearUsuario()
                    "
                class="flex items-center justify-center gap-2 bg-[#ff0000] text-white px-6 py-2 rounded w-full opacity-50 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                Crear Usuario
            </button>

            @php $dashUrl = route('dashboards.' . $scope); @endphp
            <a href="{{ $dashUrl }}"
                class="flex items-center justify-center gap-2 bg-gray-600 text-white px-6 py-2 rounded w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancelar
            </a>
        </div>

        <!-- Pie decorativo -->
        <div class="relative h-6 mt-6 bg-[#ff0000] rounded-b-lg">
            <svg class="absolute top-0 left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,100 C480,0 960,100 1440,0 L1440,100 L0,100 Z"></path>
            </svg>
        </div>

        <!-- Errores -->
        <div id="errores-validacion" class="absolute top-32 right-4 max-w-xs z-10"></div>
    </form>
@endsection

@push('scripts')
    <script>
        // URLs dinámicas según el panel actual
        const STORE_URL = "{{ route('panel.usuarios.store') }}";
        const DASHBOARD_URL = "{{ route('dashboards.' . $scope) }}";

        // CSRF (útil incluso con Sanctum)
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]').content;

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }

        function toggleCamposEspeciales() {
            const tipo = parseInt(document.getElementById('user_type_id').value);
            document.getElementById('academic_section').classList.toggle('hidden', !(tipo === 4));
            document.getElementById('empresa_section').classList.toggle('hidden', !(tipo === 2 || tipo === 3));
        }

        function validarFormulario() {
            const campos = [
                'first_name', 'last_name', 'email', 'user_type_id',
                'document_type_id', 'document_number', 'gender_id',
                'phone', 'birthdate', 'password', 'password_confirmation' // <-- agregado
            ];
            const esValido = campos.every(id => {
                const el = document.getElementById(id);
                return el && el.value.trim() !== '';
            });
            const btn = document.getElementById('btnCrear');
            btn.disabled = !esValido;
            btn.classList.toggle('opacity-50', !esValido);
            btn.classList.toggle('cursor-not-allowed', !esValido);
        }

        async function crearUsuario() {
            document.getElementById('errores-validacion').innerHTML = '';

            const data = {
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                user_type_id: document.getElementById('user_type_id').value,
                document_type_id: document.getElementById('document_type_id').value,
                document_number: document.getElementById('document_number').value,
                gender_id: document.getElementById('gender_id').value,
                phone: document.getElementById('phone').value,
                birthdate: document.getElementById('birthdate').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value, // <-- agregado
                academic_program_id: document.getElementById('academic_program_id')?.value || null,
                institution_id: document.getElementById('institution_id')?.value || null,
                company_name: document.getElementById('company_name')?.value || null,
                company_address: document.getElementById('company_address')?.value || null,
                accepted_terms: true
            };

            const roleEl = document.getElementById('role');
            if (roleEl && roleEl.value) data.role = roleEl.value;

            try {
                await axios.get('/sanctum/csrf-cookie');

                await axios.post(STORE_URL, data, {
                    headers: { 'Accept': 'application/json' },
                    withCredentials: true
                });

                const continuar = confirm("✅ Usuario creado correctamente.\n\n¿Deseas crear otro?");
                if (continuar) {
                    document.getElementById('adminCreateForm').reset();
                    toggleCamposEspeciales();
                    document.getElementById('first_name').focus();
                    validarFormulario();
                } else {
                    window.location.href = DASHBOARD_URL;
                }
            } catch (error) {
                const errores = error.response?.data?.errors || {};
                let lista = '';
                for (const campo in errores) {
                    errores[campo].forEach(msg => { lista += `<li>${msg}</li>`; });
                }

                const html = `
                    <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 shadow-lg" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div>
                            <span class="font-medium">Por favor corrige los siguientes errores:</span>
                            <ol class="mt-1.5 list-decimal list-inside">${lista || '<li>Error inesperado.</li>'}</ol>
                        </div>
                    </div>`;
                const contenedorErrores = document.getElementById('errores-validacion');
                contenedorErrores.innerHTML = html;
                setTimeout(() => { contenedorErrores.innerHTML = ''; }, 5000);
            }

            validarFormulario();
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleCamposEspeciales();
            validarFormulario();
            document.getElementById('first_name').focus();
            document.querySelectorAll('#adminCreateForm input, #adminCreateForm select').forEach(el => {
                el.addEventListener('input', validarFormulario);
                el.addEventListener('change', validarFormulario);
            });
        });
    </script>
@endpush
