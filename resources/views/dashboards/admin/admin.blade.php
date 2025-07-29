<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios</h1>

    {{-- Tabla de usuarios --}}
    <section id="tablaUsuarios">
        <table class="min-w-full table-auto text-sm text-left border-collapse border">
            <thead class="bg-gray-100 border-b">
            <tr class="text-gray-600 uppercase text-xs tracking-wider">
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Correo</th>
                <th class="px-4 py-3">Rol</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach ($users as $usuario)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                    <td class="px-4 py-2">{{ $usuario->email }}</td>
                    <td class="px-4 py-2">{{ $usuario->roles->pluck('name')->implode(', ') }}</td>
                    <td class="px-4 py-2 text-center flex gap-2 justify-center items-center">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                onclick="editarUsuario({{ $usuario->id }})">
                            Editar
                        </button>
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar este usuario?')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    {{-- Formulario de edición --}}
    <section id="formularioEdicion" class="hidden mt-10">
        <h2 class="text-xl font-semibold mb-6 text-gray-700">Editar Usuario</h2>

        <form id="formEditarUsuario" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Campos de texto --}}
                @php
                    $camposTexto = [
                        'first_name' => 'Primer Nombre',
                        'last_name' => 'Apellido',
                        'email' => 'Correo Electrónico',
                        'birthdate' => 'Fecha de Nacimiento',
                        'document_number' => 'Número de Documento'
                    ];
                @endphp

                @foreach ($camposTexto as $id => $label)
                    <div>
                        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                        <input type="{{ $id === 'email' ? 'email' : ($id === 'birthdate' ? 'date' : 'text') }}"
                               id="{{ $id }}" name="{{ $id }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endforeach

                {{-- Selects dinámicos --}}
                @foreach ([
                    'gender_id' => $genders,
                    'document_type_id' => $documentTypes,
                    'user_type_id' => $userTypes,
                    'academic_program_id' => $academicPrograms,
                    'institution_id' => $institutions
                ] as $id => $collection)
                    <div>
                        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
                            {{ ucwords(str_replace('_', ' ', $id)) }}
                        </label>
                        <select id="{{ $id }}" name="{{ $id }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                onchange="{{ $id === 'user_type_id' ? 'toggleCamposEmpresa()' : '' }}">
                            <option value="">Seleccione</option>
                            @foreach ($collection as $item)
                                <option value="{{ $item->id }}">{{ $item->name ?? $item->type }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                {{-- Campos de empresa --}}
                <div id="campo_empresa" class="col-span-2 hidden">
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

            <div class="flex gap-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Actualizar
                </button>
                <button type="button" onclick="cancelarEdicion()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    Cancelar
                </button>
            </div>
        </form>
    </section>
</div>

<script>
    const usuarios = @json($users);

    function editarUsuario(id) {
        const user = usuarios.find(u => u.id === id);
        if (!user) return alert('Usuario no encontrado');

        // Mostrar/Ocultar secciones
        document.getElementById('tablaUsuarios').classList.add('hidden');
        document.getElementById('formularioEdicion').classList.remove('hidden');

        // Rellenar formulario
        const form = document.getElementById('formEditarUsuario');
        form.action = `/usuarios/${id}`;
        form.first_name.value = user.first_name || '';
        form.last_name.value = user.last_name || '';
        form.email.value = user.email || '';
        form.birthdate.value = user.birthdate || '';
        form.document_number.value = user.document_number || '';
        form.company_name.value = user.company_name || '';
        form.company_address.value = user.company_address || '';
        form.gender_id.value = user.gender_id || '';
        form.document_type_id.value = user.document_type_id || '';
        form.user_type_id.value = user.user_type_id || '';
        form.academic_program_id.value = user.academic_program_id || '';
        form.institution_id.value = user.institution_id || '';

        toggleCamposEmpresa();
    }

    function cancelarEdicion() {
        document.getElementById('formEditarUsuario').reset();
        document.getElementById('formularioEdicion').classList.add('hidden');
        document.getElementById('tablaUsuarios').classList.remove('hidden');
    }

    function toggleCamposEmpresa() {
        const tipo = document.getElementById('user_type_id').value;
        const mostrar = tipo == 3; // ID 3 para Compañía
        document.getElementById('campo_empresa').classList.toggle('hidden', !mostrar);
    }
</script>

</body>
</html>
