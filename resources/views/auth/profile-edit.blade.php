<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Información del Perfil</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

@php
    // Detecta el panel actual para construir las rutas
    $scope = auth()->user()->hasRole('superadmin') ? 'superadmin' : 'admin';
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">

<form id="editUserForm" class="w-[720px] bg-white rounded-lg shadow-lg p-6 relative" action="{{ route('profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Cabecera decorativa -->
    <div class="relative h-6 bg-[#ff0000] rounded-t-lg">
        <svg class="absolute top-full left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path fill="#ffffff" d="M0,0 C480,100 960,0 1440,100 L1440,0 L0,0 Z"></path>
        </svg>
    </div>

    <h2 class="text-2xl font-bold mt-6 mb-4 text-center text-gray-800">Editar mi Información</h2>

    <!-- Datos personales -->
    <div class="grid gap-4 mb-6 md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Nombres</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="Nombres">
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="Apellidos">
        </div>
        <div class="md:col-span-2">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="ejemplo@correo.com">
        </div>
    </div>

    <!-- Documento y tipo -->
    <div class="grid gap-4 mb-6 md:grid-cols-3">
        <div>
            <label for="user_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Usuario</label>
            <select id="user_type_id" name="user_type_id"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
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
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
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
            <input type="text" id="document_number" name="document_number" value="{{ old('document_number', auth()->user()->document_number) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="1234567890">
        </div>
    </div>

    <!-- Campos adicionales reactivos -->
    <div id="academic_section" class="col-span-2 hidden">
        <div class="mb-4">
            <label for="academic_program_id" class="block text-sm font-medium text-gray-700">Programa Académico</label>
            <select id="academic_program_id" name="academic_program_id"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                <option value="">Seleccione</option>
                @foreach ($academicPrograms as $program)
                    <option value="{{ $program->id }}" {{ old('academic_program_id', auth()->user()->academic_program_id) == $program->id ? 'selected' : '' }}>
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución</label>
            <select id="institution_id" name="institution_id"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                <option value="">Seleccione</option>
                @foreach ($institutions as $inst)
                    <option value="{{ $inst->id }}" {{ old('institution_id', auth()->user()->institution_id) == $inst->id ? 'selected' : '' }}>
                        {{ $inst->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="empresa_section" class="col-span-2 hidden">
        <div class="mb-4">
            <label for="company_name" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
            <input type="text" id="company_name" name="company_name"
                   value="{{ old('company_name', auth()->user()->company_name) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
        </div>
        <div>
            <label for="company_address" class="block text-sm font-medium text-gray-700">Dirección de la Empresa</label>
            <input type="text" id="company_address" name="company_address"
                   value="{{ old('company_address', auth()->user()->company_address) }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
        </div>
    </div>

    <!-- Campos adicionales -->
    <div class="grid gap-4 mb-6 md:grid-cols-3">
        <div>
            <label for="gender_id" class="block mb-2 text-sm font-medium text-gray-900">Sexo</label>
            <select id="gender_id" name="gender_id"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
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
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="3101234567">
        </div>
        <div>
            <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900">Fecha de Nacimiento</label>
            <input type="text" id="birthdate" name="birthdate"
                   value="{{ old('birthdate', $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') : '') }}"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="dd/mm/aaaa">
        </div>
    </div>

    <!-- Foto de perfil -->
    <div class="mb-6">
        <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Foto de Perfil</label>
        <input type="file" id="photo" name="photo"
               class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
        @if(auth()->user()->photo)
            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto de Perfil" class="mt-4 h-32 w-32 rounded-full object-cover">
        @endif
    </div>

    <!-- Restablecer Contraseña -->
    <div class="col-span-2 mt-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Restablecer Contraseña</h3>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
            <input type="password" id="password" name="password"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="Nueva contraseña">
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                   placeholder="Confirmar nueva contraseña">
        </div>
    </div>

    <!-- Botones -->
    <div class="flex gap-4 mt-6">
        <button type="submit" id="btnActualizar" disabled
                class="bg-[#ff0000] text-white px-6 py-2 rounded w-full opacity-50 cursor-not-allowed">
            Actualizar Información
        </button>
        <a href="{{ route('panel') }}" class="bg-gray-600 text-white px-6 py-2 rounded w-full text-center">
            Cancelar
        </a>
    </div>

    <!-- Pie decorativo -->
    <div class="relative h-6 mt-6 bg-[#ff0000] rounded-b-lg">
        <svg class="absolute top-0 left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path fill="#ffffff" d="M0,100 C480,0 960,100 1440,0 L1440,100 L0,100 Z"></path>
        </svg>
    </div>
</form>

<script>
    // ====== BASE ORIGINAL ======
    // Lógica para habilitar el botón de actualización solo si los campos son válidos
    const formInputs = document.querySelectorAll('#editUserForm input, #editUserForm select');
    const btnActualizar = document.getElementById('btnActualizar');

    // Activar/desactivar campos según el tipo de usuario
    document.getElementById('user_type_id').addEventListener('change', function() {
        const tipo = this.value;
        const academicSection = document.getElementById('academic_section');
        const empresaSection = document.getElementById('empresa_section');

        console.log("📌 Cambio de tipo de usuario:", tipo);

        if (tipo == 4) { // Estudiantes
            academicSection.classList.remove('hidden');
            empresaSection.classList.add('hidden');
            console.log("➡️ Se muestra sección académica");
        } else if (tipo == 2 || tipo == 3) { // Empresas
            empresaSection.classList.remove('hidden');
            academicSection.classList.add('hidden');
            console.log("➡️ Se muestra sección empresa");
        } else {
            academicSection.classList.add('hidden');
            empresaSection.classList.add('hidden');
            console.log("➡️ No se muestra sección adicional");
        }
    });

    // Ejecutar al cargar la página para mostrar/hide los campos reactivos según el tipo
    document.getElementById('user_type_id').dispatchEvent(new Event('change'));

    function validarFormulario() {
        let formValido = true;
        let camposEstado = [];

        formInputs.forEach(input => {
            let valido = true;

            if (input.required && !input.value.trim()) {
                valido = false;
                formValido = false;
            }

            camposEstado.push({
                name: input.name,
                value: input.value,
                requerido: input.required,
                valido: valido
            });
        });

        console.log("📝 Estado de los campos:", camposEstado);
        console.log("✅ ¿Formulario válido?:", formValido);

        btnActualizar.disabled = !formValido;
        btnActualizar.classList.toggle('opacity-50', !formValido);
        btnActualizar.classList.toggle('cursor-not-allowed', !formValido);

        return { formValido, camposEstado };
    }

    formInputs.forEach(input => {
        input.addEventListener('input', validarFormulario);
        input.addEventListener('change', validarFormulario);
    });

    validarFormulario(); // Validación inicial

    // ====== EXTENSIÓN: try/catch para saber qué datos NO pasan al controlador ======
    // Utilidades mínimas para pintar errores de validación del backend (422)
    function clearFieldErrors(form) {
        form.querySelectorAll('.ring-2').forEach(i => i.classList.remove('ring-2','ring-red-400'));
        form.querySelectorAll('[data-error-label="true"]').forEach(l => l.remove());
    }
    function setFieldErrors(form, errors) {
        Object.entries(errors).forEach(([field, msgs]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (!input) return;
            input.classList.add('ring-2','ring-red-400');
            const label = document.createElement('div');
            label.dataset.errorLabel = "true";
            label.className = 'text-xs text-red-600 mt-1';
            label.textContent = msgs.join(' ');
            input.insertAdjacentElement('afterend', label);
        });
    }

    // ====== NUEVO: limpiar FormData (no enviar vacíos) ======
    function limpiarFormData(fd) {
        // Reconstituye el FormData preservando múltiples valores (e.g., roles[])
        const limpio = new FormData();
        const omitidos = new Set();

        // Recolectamos todas las keys únicas
        const keys = Array.from(fd.keys());

        keys.forEach((key) => {
            const valores = fd.getAll(key);
            let agregóAlguno = false;

            valores.forEach((valor) => {
                // Si es archivo, solo enviar si tiene tamaño (>0)
                if (valor instanceof File) {
                    if (valor && valor.size > 0) {
                        limpio.append(key, valor);
                        agregóAlguno = true;
                    }
                    return;
                }
                // Para strings u otros: trim y omitir vacíos
                const str = String(valor ?? '').trim();
                if (str !== '') {
                    limpio.append(key, valor);
                    agregóAlguno = true;
                }
            });

            if (!agregóAlguno) {
                omitidos.add(key);
            }
        });

        // Loguea qué campos se omiten (quedan “como estaban” en el backend)
        if (omitidos.size) {
            console.log('🧹 Campos omitidos por venir vacíos (no se envían):', Array.from(omitidos));
        }

        return limpio;
    }

    // Envío con Axios capturando 422 (qué campos no pasan) + limpieza de vacíos
    (function setupEnvio() {
        const form = document.getElementById('editUserForm');
        if (!form) return;

        // Configuración CSRF si existe meta (Laravel)
        if (typeof axios !== 'undefined') {
            const csrf = document.querySelector('meta[name="csrf-token"]');
            if (csrf) {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.getAttribute('content');
            }
        } else {
            console.warn('Axios no está disponible. Incluye su script antes de este bloque.');
            return;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            clearFieldErrors(form);

            const { formValido } = validarFormulario();

            // Construir y loguear payload ANTES de limpiar
            let fd = new FormData(form);
            const payloadOriginal = {};
            fd.forEach((v, k) => payloadOriginal[k] = v);
            console.log("📨 Payload (original) a enviar:", payloadOriginal);

            if (!formValido) {
                console.warn("❌ Formulario inválido en cliente. Corrige los campos requeridos antes de enviar.");
                return;
            }

            // 🔥 Limpia campos vacíos para “saltar” lo no enviado
            fd = limpiarFormData(fd);

            // Spoofing PUT tras limpiar (para no duplicar _method)
            if (!fd.has('_method')) fd.append('_method', 'PUT');

            // Log del payload definitivo
            const payloadLimpio = {};
            fd.forEach((v, k) => payloadLimpio[k] = (v instanceof File ? `(File:${v.name},${v.size}B)` : v));
            console.log("📨 Payload (limpio) a enviar:", payloadLimpio);

            // Estado loading en botón
            const originalText = btnActualizar.textContent;
            btnActualizar.disabled = true;
            btnActualizar.textContent = 'Actualizando…';

            try {
                // Usa la action del form o define una por defecto
                const url = form.getAttribute('action') || '/users/1';

                const res = await axios.post(url, fd, { headers: { 'Accept': 'application/json' } });
                console.log("✅ Respuesta OK del backend:", res.data);
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    // Campos que NO pasaron la validación/guardado en el controlador
                    const errors = error.response.data?.errors || {};
                    const camposConError = Object.keys(errors);

                    console.error("❌ Errores de validación del backend:", errors);
                    console.warn("🧩 Campos que NO pasaron al controlador:", camposConError);

                    // Pintar errores junto a cada campo
                    setFieldErrors(form, errors);

                    // Resumen rápido
                    alert('Campos con error: ' + (camposConError.join(', ') || '—'));
                } else {
                    console.error("⚠️ Error inesperado al enviar:", error);
                    alert('Ocurrió un error inesperado al actualizar.');
                }
            } finally {
                btnActualizar.disabled = false;
                btnActualizar.textContent = originalText;
            }
        });
    })();
</script>

</body>
</html>
