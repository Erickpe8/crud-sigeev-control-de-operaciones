<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard para administradores</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Panel de Administrador</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition-all duration-300">
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="bg-white p-4 shadow rounded mb-6">
        <p>Bienvenido administrador, desde aquí puedes gestionar usuarios y editar roles, a excepción del super administrador.</p>
    </div>

    <div class="bg-white p-6 shadow rounded overflow-auto">
        <h2 class="text-xl font-semibold mb-4">Gestión de Usuarios</h2>
        <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-3 py-2">Nombre</th>
                    <th class="border px-3 py-2">Email</th>
                    <th class="border px-3 py-2">Rol</th>
                    <th class="border px-3 py-2">Género</th>
                    <th class="border px-3 py-2">Tipo Doc</th>
                    <th class="border px-3 py-2"># Documento</th>
                    <th class="border px-3 py-2">Tipo Usuario</th>
                    <th class="border px-3 py-2">Programa Académico</th>
                    <th class="border px-3 py-2">Institución</th>
                    <th class="border px-3 py-2">Estado</th>
                    <th class="border px-3 py-2">Términos</th>
                    <th class="border px-3 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody id="users-table">
                @foreach ($users as $user)
                    <tr class="text-center user-row" id="row-{{ $user->id }}">
                        <td class="border px-3 py-2" id="name-{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="border px-3 py-2" id="email-{{ $user->id }}">{{ $user->email }}</td>
                        <td class="border px-3 py-2" id="role-{{ $user->id }}">{{ $user->getRoleNames()->join(', ') }}</td>
                        <td class="border px-3 py-2" id="gender-{{ $user->id }}">{{ $user->gender->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2" id="doctype-{{ $user->id }}">{{ $user->documentType->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2" id="docnum-{{ $user->id }}">{{ $user->document_number }}</td>
                        <td class="border px-3 py-2" id="usertype-{{ $user->id }}">{{ $user->userType->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2" id="program-{{ $user->id }}">{{ $user->academicProgram->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2" id="institution-{{ $user->id }}">{{ $user->institution->name ?? 'N/A' }}</td>
                        <td class="border px-3 py-2" id="status-{{ $user->id }}">{{ $user->status ? 'Activo' : 'Inactivo' }}</td>
                        <td class="border px-3 py-2" id="terms-{{ $user->id }}">{{ $user->accepted_terms ? 'Sí' : 'No' }}</td>
                        <td class="border px-3 py-2" id="actions-{{ $user->id }}">
                            @if (!$user->hasRole('super admin'))
                                <button onclick="enableEdit({{ $user->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">
                                    Editar
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Eliminar
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 italic">Super admin</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function enableEdit(id) {
            const fields = ['name', 'email', 'role', 'gender', 'doctype', 'docnum', 'usertype', 'program', 'institution', 'status', 'terms'];
            fields.forEach(field => {
                const cell = document.getElementById(`${field}-${id}`);
                if (!cell) return;
                const value = cell.textContent.trim();
                if (field === 'name') {
                    const [first, ...last] = value.split(' ');
                    cell.innerHTML = `<input id="edit-first-${id}" type="text" value="${first}" class="border p-1 w-20 rounded"> <input id="edit-last-${id}" type="text" value="${last.join(' ')}" class="border p-1 w-20 rounded">`;
                } else if (field === 'email') {
                    cell.innerHTML = `<input id="edit-email-${id}" type="email" value="${value}" class="border p-1 w-48 rounded">`;
                } else {
                    cell.innerHTML = `<input id="edit-${field}-${id}" type="text" value="${value}" class="border p-1 w-24 rounded">`;
                }
            });

            document.getElementById(`actions-${id}`).innerHTML = `
                <button onclick="saveEdit(${id})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded mr-2">Guardar</button>
                <button onclick="cancelEdit()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">Cancelar</button>
            `;
        }

        function cancelEdit() {
            location.reload();
        }

        function saveEdit(id) {
            const first_name = document.getElementById(`edit-first-${id}`).value;
            const last_name = document.getElementById(`edit-last-${id}`).value;
            const email = document.getElementById(`edit-email-${id}`).value;
            const role = document.getElementById(`edit-role-${id}`)?.value || '';
            const gender = document.getElementById(`edit-gender-${id}`)?.value || '';
            const document_type = document.getElementById(`edit-doctype-${id}`)?.value || '';
            const document_number = document.getElementById(`edit-docnum-${id}`)?.value || '';
            const user_type = document.getElementById(`edit-usertype-${id}`)?.value || '';
            const program = document.getElementById(`edit-program-${id}`)?.value || '';
            const institution = document.getElementById(`edit-institution-${id}`)?.value || '';
            const status = document.getElementById(`edit-status-${id}`)?.value || '';
            const terms = document.getElementById(`edit-terms-${id}`)?.value || '';

            fetch(`/users/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    first_name,
                    last_name,
                    email,
                    role,
                    gender_id: gender,
                    document_type_id: document_type,
                    document_number,
                    user_type_id: user_type,
                    academic_program_id: program,
                    institution_id: institution,
                    status: status.toLowerCase() === 'activo',
                    accepted_terms: terms.toLowerCase() === 'sí'
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al guardar');
                return response.json();
            })
            .then(data => {
                alert('Usuario actualizado con éxito');
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Ocurrió un error al guardar los cambios');
            });
        }
    </script>

</body>
</html>
