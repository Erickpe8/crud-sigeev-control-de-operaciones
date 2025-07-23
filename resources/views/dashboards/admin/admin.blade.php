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

    <div class="bg-white p-6 shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Gestión de Usuarios</h2>
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Rol</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="text-center" id="row-{{ $user->id }}">
                        <td class="border border-gray-300 px-4 py-2" id="name-{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="email-{{ $user->id }}">{{ $user->email }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="role-{{ $user->id }}">{{ $user->getRoleNames()->join(', ') }}</td>
                        <td class="border border-gray-300 px-4 py-2" id="actions-{{ $user->id }}">
                            @if (!$user->hasRole('super admin'))
                                <button onclick="enableEdit({{ $user->id }}, '{{ $user->first_name }}', '{{ $user->last_name }}', '{{ $user->email }}', '{{ $user->getRoleNames()->first() }}')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">
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
        function enableEdit(id, firstName, lastName, email, role) {
            document.getElementById(`name-${id}`).innerHTML = `
                <input id="edit-first-${id}" type="text" value="${firstName}" class="border px-2 py-1 w-24 rounded" />
                <input id="edit-last-${id}" type="text" value="${lastName}" class="border px-2 py-1 w-24 rounded" />
            `;

            document.getElementById(`email-${id}`).innerHTML = `
                <input id="edit-email-${id}" type="email" value="${email}" class="border px-2 py-1 w-48 rounded" />
            `;

            document.getElementById(`role-${id}`).innerHTML = `
                <select id="edit-role-${id}" class="border px-2 py-1 rounded">
                    <option value="user" ${role === 'user' ? 'selected' : ''}>user</option>
                    <option value="admin" ${role === 'admin' ? 'selected' : ''}>admin</option>
                </select>
            `;

            document.getElementById(`actions-${id}`).innerHTML = `
                <button onclick="saveEdit(${id})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded mr-2">Guardar</button>
                <button onclick="location.reload()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">Cancelar</button>
            `;
        }

        function saveEdit(id) {
            const first_name = document.getElementById(`edit-first-${id}`).value;
            const last_name = document.getElementById(`edit-last-${id}`).value;
            const email = document.getElementById(`edit-email-${id}`).value;
            const role = document.getElementById(`edit-role-${id}`).value;

            fetch(`/users/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ first_name, last_name, email, role })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al guardar');
                return response.json();
            })
            .then(data => {
                alert('Usuario actualizado con éxito');
                location.reload(); // recargar para ver los cambios reflejados
            })
            .catch(error => {
                console.error(error);
                alert('Ocurrió un error al guardar los cambios');
            });
        }
    </script>

</body>
</html>
