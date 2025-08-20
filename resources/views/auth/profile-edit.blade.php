<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
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

<form id="editUserForm" class="w-[720px] bg-white rounded-lg shadow-lg p-6 relative">
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
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nombres">
        </div>
        <div>
            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Apellidos">
        </div>
        <div class="md:col-span-2">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="ejemplo@correo.com">
        </div>
    </div>

    <!-- Documento y tipo -->
    <div class="grid gap-4 mb-6 md:grid-cols-3">
        <div>
            <label for="user_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Usuario</label>
            <select id="user_type_id" name="user_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Selecciona</option>
                @foreach ($userTypes as $type)
                    <option value="{{ $type->id }}" {{ auth()->user()->user_type_id == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="document_type_id" class="block mb-2 text-sm font-medium text-gray-900">Tipo de Documento</label>
            <select id="document_type_id" name="document_type_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Selecciona</option>
                @foreach ($documentTypes as $doc)
                    <option value="{{ $doc->id }}" {{ auth()->user()->document_type_id == $doc->id ? 'selected' : '' }}>{{ $doc->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="document_number" class="block mb-2 text-sm font-medium text-gray-900">Número de Documento</label>
            <input type="text" id="document_number" name="document_number" value="{{ old('document_number', auth()->user()->document_number) }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1234567890">
        </div>
    </div>

    <!-- Campos adicionales -->
    <div class="grid gap-4 mb-6 md:grid-cols-3">
        <div>
            <label for="gender_id" class="block mb-2 text-sm font-medium text-gray-900">Sexo</label>
            <select id="gender_id" name="gender_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Selecciona</option>
                @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" {{ auth()->user()->gender_id == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="3101234567">
        </div>
        <div>
            <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900">Fecha de Nacimiento</label>
            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', auth()->user()->birthdate) }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
    </div>

    <!-- Foto de perfil -->
    <div class="mb-6">
        <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Foto de Perfil</label>
        <input type="file" id="photo" name="photo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        @if(auth()->user()->photo)
            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto de Perfil" class="mt-4 h-32 w-32 rounded-full object-cover">
        @endif
    </div>

    <!-- Botones -->
    <div class="flex gap-4 mt-6">
        <button type="submit" id="btnActualizar" disabled class="bg-[#ff0000] text-white px-6 py-2 rounded w-full opacity-50 cursor-not-allowed">
            Actualizar Información
        </button>
        <a href="{{ route('dashboards.' . $scope) }}" class="bg-gray-600 text-white px-6 py-2 rounded w-full">
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
    // Lógica para habilitar el botón de actualización solo si los campos son válidos
    const formInputs = document.querySelectorAll('#editUserForm input, #editUserForm select');
    const btnActualizar = document.getElementById('btnActualizar');

    function validarFormulario() {
        let formValido = true;
        formInputs.forEach(input => {
            if (input.required && !input.value.trim()) {
                formValido = false;
            }
        });

        btnActualizar.disabled = !formValido;
        btnActualizar.classList.toggle('opacity-50', !formValido);
        btnActualizar.classList.toggle('cursor-not-allowed', !formValido);
    }

    formInputs.forEach(input => {
        input.addEventListener('input', validarFormulario);
        input.addEventListener('change', validarFormulario);
    });

    validarFormulario(); // Validación inicial
</script>

</body>
</html>
