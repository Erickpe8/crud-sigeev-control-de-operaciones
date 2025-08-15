<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Superadministración</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div id="infoPanel" class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios — Superadmin</h1>
    <div id="mensajeBienvenida" class="bg-white p-4 shadow rounded">
        <p class="text-gray-700 leading-relaxed">
            Bienvenido, <strong>Superadministrador</strong>. Aquí puedes <strong>crear, editar, eliminar</strong> y
            <strong>asignar roles</strong> a cualquier usuario del sistema, incluidos administradores.
            <br><br>
            Por seguridad, no podrás <strong>auto‑eliminarte ni auto‑degradarte</strong> desde este panel.
        </p>

        {{-- Buscador + Registrar + Logout --}}
        <div class="mt-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Buscador -->
            <form method="GET" class="flex-1">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1010 18a7.5 7.5 0 006.65-6.85z"/>
                        </svg>
                    </div>

                    <input
                        type="search" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Buscar por nombre o correo..."
                        class="block w-full p-4 pl-10
                            pr-40 md:pr-56  {{-- espacio para 2 botones --}}
                            text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                            focus:ring-blue-500 focus:border-blue-500">

                    <!-- Grupo de botones dentro del input -->
                    <div class="absolute right-2.5 bottom-2.5 flex gap-2">
                        <button type="button" id="btnClearSearch"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-sm px-4 py-2
                                    focus:outline-none focus:ring-4 focus:ring-gray-300">
                            Limpiar
                        </button>
                        <button type="submit"
                                class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-4 py-2
                                    focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Botón Registrar -->
            <div>
                <a href="{{ route('panel.usuarios.crear') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow block text-center">
                    Registrar Un Nuevo Usuario
                </a>
            </div>

            <!-- Botón Cerrar sesión -->
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow block text-center">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
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
            <tbody class="divide-y divide-gray-200" id="tablaCuerpoUsuarios">
            @foreach ($users as $usuario)
                @php
                    $rolesStr = $usuario->roles->pluck('name')->implode(', ');
                    $isSuper = $usuario->hasRole('superadmin');
                    $isSelf  = auth()->id() === $usuario->id;
                @endphp
                <tr class="hover:bg-gray-50 transition fila-usuario">
                    <td class="px-4 py-2">{{ $usuario->first_name }} {{ $usuario->last_name }}</td>
                    <td class="px-4 py-2">{{ $usuario->email }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-xs
                                {{ $isSuper ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $rolesStr ?: 'sin rol' }}
                            </span>
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center flex gap-2 justify-center items-center">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs"
                                onclick="editarUsuario({{ $usuario->id }})">
                            Editar
                        </button>

                        <form method="POST" action="{{ route('superadmin.usuarios.destroy', $usuario) }}" class="inline-block"
                              onsubmit="return confirmarEliminacion({{ $usuario->id }}, {{ $isSelf ? 'true' : 'false' }}, {{ $isSuper ? 'true' : 'false' }})">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                Eliminar
                            </button>
                        </form><!--  -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-6 flex justify-center">
            {{ $users->links('pagination::tailwind') }}
        </div>
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
                            id="{{ $id }}" name="{{ $id }}" value=""
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endforeach

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
                        @foreach ($roles as $role)
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
                            @foreach ($academicPrograms as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución</label>
                        <select id="institution_id" name="institution_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
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

<script>
    const usuarios = @json($users->toArray()['data'] ?? []);
    const form = document.getElementById('formEditarUsuario');
    const btnActualizar = document.getElementById('btnActualizar');
    const authId = {{ auth()->id() }};

    const camposRequeridos = ['first_name','last_name','email','birthdate','document_number','gender_id','document_type_id','user_type_id'];
    const camposEstudiante = ['academic_program_id','institution_id'];
    const camposEmpresa = ['company_name','company_address'];

    function editarUsuario(id) {
        const user = usuarios.find(u => u.id === id);
        if (!user) return alert('⚠️ Usuario no encontrado');

        document.getElementById('tablaUsuarios').classList.add('hidden');
        document.getElementById('formularioEdicion').classList.remove('hidden');
        document.getElementById('mensajeBienvenida')?.classList.add('hidden');

        form.action = `/superadmin/usuarios/${id}`;

        // Relleno base
        const fields = [...camposRequeridos, ...camposEstudiante, ...camposEmpresa];
        fields.forEach(field => {
            if (form[field]) {
                let value = user[field] ?? '';
                if (field === 'birthdate' && value) value = new Date(value).toISOString().split('T')[0];
                form[field].value = value;
            }
        });

        // Rol actual (toma el primero)
        const currentRole = (user.roles && user.roles.length) ? user.roles[0].name : 'user';
        if (form['role']) form['role'].value = currentRole;

        toggleCamposEspeciales();
        validarFormulario();
    }

    function cancelarEdicion() {
        form.reset();
        toggleCamposEspeciales();
        validarFormulario();
        document.getElementById('formularioEdicion').classList.add('hidden');
        document.getElementById('tablaUsuarios').classList.remove('hidden');
        document.getElementById('mensajeBienvenida')?.classList.remove('hidden');
    }

    function toggleCamposEspeciales() {
        const tipo = parseInt(form['user_type_id'].value);
        const academic = document.getElementById('academic_section');
        const empresa = document.getElementById('empresa_section');

        academic.classList.toggle('hidden', tipo !== 4);
        empresa.classList.toggle('hidden', !(tipo === 2 || tipo === 3));

        if (tipo !== 4) { form['academic_program_id'].value = ''; form['institution_id'].value = ''; }
        if (!(tipo === 2 || tipo === 3)) { form['company_name'].value = ''; form['company_address'].value = ''; }

        validarFormulario();
    }

    function validarFormulario() {
        let esValido = true;

        camposRequeridos.forEach(id => {
            const el = form[id];
            if (!el || el.value.trim() === '') esValido = false;
        });

        const tipo = parseInt(form['user_type_id'].value);
        if (tipo === 4) camposEstudiante.forEach(id => { if (!form[id]?.value.trim()) esValido = false; });
        if (tipo === 2 || tipo === 3) camposEmpresa.forEach(id => { if (!form[id]?.value.trim()) esValido = false; });

        btnActualizar.disabled = !esValido;
        btnActualizar.classList.toggle('opacity-50', !esValido);
        btnActualizar.classList.toggle('cursor-not-allowed', !esValido);
    }

    // Seguridad para eliminar
    function confirmarEliminacion(userId, isSelf, isSuper) {
        if (isSelf) { alert('No puedes eliminar tu propia cuenta.'); return false; }
        // Si el objetivo es superadmin, confirmación extra
        if (isSuper && !confirm('Estás eliminando a un SUPERADMIN. ¿Confirmas?')) return false;
        return confirm('¿Eliminar este usuario?');
    }

    // Wiring
    form.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', validarFormulario);
        el.addEventListener('change', validarFormulario);
    });
    // (El input de búsqueda correcto es #search)

    document.getElementById('btnClearSearch')?.addEventListener('click', function () {
    const searchInput = document.getElementById('search');
    searchInput.value = '';

    // Frontend: mostrar todas las filas
    document.querySelectorAll('.fila-usuario').forEach(fila => fila.style.display = '');

    // Backend: recargar sin query params (opcional, útil si usas paginación/consulta)
    window.location.href = window.location.pathname;
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Inyecta CSS para ocultar la "X" del input search en navegadores Webkit
        const style = document.createElement('style');
        style.innerHTML = `
            input[type="search"]::-webkit-search-cancel-button {
                -webkit-appearance: none;
                appearance: none;
            }
        `;
        document.head.appendChild(style);
    });

    validarFormulario();
</script>

<script>
document.getElementById('formEditarUsuario').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Convertir FormData a objeto para poder mostrarlo en tabla
    const payload = {};
    formData.forEach((value, key) => payload[key] = value);

    // Mostrar datos en tabla
    console.table(payload);

    try {
        const response = await axios.post(form.action, formData, {
            headers: { 'Accept': 'application/json' }
        });
        console.log('%c✅ Usuario actualizado correctamente', 'color: green; font-weight: bold;');
        console.log(response.data); // Opcional: ver respuesta del servidor

        alert('✅ Usuario actualizado correctamente');
        location.reload();
    } catch (error) {
        console.error('%c❌ Error en la petición', 'color: red; font-weight: bold;');

        if (error.response) {
            console.error('Código de estado:', error.response.status);
            console.error('Respuesta del servidor:', error.response.data);

            if (error.response.status === 422) {
                console.warn('Errores de validación detectados:');
                console.table(error.response.data.errors);
            }
        } else if (error.request) {
            console.error('No hubo respuesta del servidor.');
            console.error(error.request);
        } else {
            console.error('Error al configurar la solicitud:', error.message);
        }
    }
});
</script>

</body>
</html>
