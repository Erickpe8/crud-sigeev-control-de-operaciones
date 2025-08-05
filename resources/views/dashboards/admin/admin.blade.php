<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios</h1>

    {{-- Botón para registrar nuevo usuario --}}
        <div class="mb-6 text-right">
            <a href="{{ route('admin.usuarios.crear') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                Registrar Un Nuevo Usuario
            </a>
        </div>

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
                        <input
                            type="{{ $id === 'email' ? 'email' : ($id === 'birthdate' ? 'date' : 'text') }}"
                            id="{{ $id }}"
                            name="{{ $id }}"
                            value=""
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                @endforeach

                {{-- Selects dinámicos --}}
                @foreach ([
                    'gender_id' => $genders,
                    'document_type_id' => $documentTypes,
                    'user_type_id' => $userTypes
                ] as $id => $collection)
                    <div>
                        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
                            {{ ucwords(str_replace('_', ' ', $id)) }}
                        </label>
                        <select id="{{ $id }}" name="{{ $id }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                onchange="toggleCamposEspeciales()">
                            <option value="">Seleccione</option>
                            @foreach ($collection as $item)
                                <option value="{{ $item->id }}">{{ $item->name ?? $item->type }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                {{-- Campos adicionales dinámicos --}}
                <div id="academic_section" class="col-span-2 hidden">
                    <div class="mb-4">
                        <label for="academic_program_id" class="block text-sm font-medium text-gray-700">Programa Académico</label>
                        <select id="academic_program_id" name="academic_program_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            @foreach ($academicPrograms as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución</label>
                        <select id="institution_id" name="institution_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione</option>
                            @foreach ($institutions as $inst)
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
        if (!user) return alert('⚠️ Usuario no encontrado');

        document.getElementById('tablaUsuarios').classList.add('hidden');
        document.getElementById('formularioEdicion').classList.remove('hidden');

        const form = document.getElementById('formEditarUsuario');
        form.action = `/usuarios/${id}`;

        const fields = [
            'first_name', 'last_name', 'email', 'birthdate',
            'document_number', 'gender_id', 'document_type_id',
            'user_type_id', 'academic_program_id', 'institution_id',
            'company_name', 'company_address'
        ];

        fields.forEach(field => {
            if (form[field]) {
                let value = user[field] ?? '';
                if (field === 'birthdate' && value) {
                    value = new Date(value).toISOString().split('T')[0];
                }
                form[field].value = value;
            }
        });

        toggleCamposEspeciales();
    }

    function cancelarEdicion() {
        const form = document.getElementById('formEditarUsuario');
        form.reset();
        toggleCamposEspeciales();
        document.getElementById('formularioEdicion').classList.add('hidden');
        document.getElementById('tablaUsuarios').classList.remove('hidden');
    }

    function toggleCamposEspeciales() {
        const tipo = parseInt(document.getElementById('user_type_id').value);
        const academic = document.getElementById('academic_section');
        const empresa = document.getElementById('empresa_section');

        const esEstudiante = tipo === 4;
        const esEmpresa = tipo === 2 || tipo === 3;

        academic.classList.toggle('hidden', !esEstudiante);
        empresa.classList.toggle('hidden', !esEmpresa);

        if (!esEstudiante) {
            document.getElementById('academic_program_id').value = '';
            document.getElementById('institution_id').value = '';
        }
        if (!esEmpresa) {
            document.getElementById('company_name').value = '';
            document.getElementById('company_address').value = '';
        }
    }

    document.getElementById('user_type_id').addEventListener('change', toggleCamposEspeciales);

    document.getElementById('formEditarUsuario').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');
        formData.set('accepted_terms', 1);

        console.log('📦 Datos enviados al servidor:');
        for (let [clave, valor] of formData.entries()) {
            console.log(`${clave}: ${valor}`);
        }

        try {
            const response = await axios.post(form.action, formData, {
                headers: { 'Accept': 'application/json' }
            });

            alert('✅ Usuario actualizado correctamente');
            location.reload();

        } catch (error) {
            if (error.response) {
                const status = error.response.status;
                if (status === 422) {
                    const errors = error.response.data.errors;
                    let mensaje = 'Corrige los siguientes errores:\n';
                    for (const campo in errors) {
                        mensaje += `- ${errors[campo].join(', ')}\n`;
                    }
                    alert(mensaje);
                } else {
                    alert(`❌ Error del servidor (código ${status})\n${error.response.data.message}`);
                }
            } else {
                alert('❌ Error inesperado al enviar la solicitud.');
            }
        }
    });
</script>

</body>
</html>
