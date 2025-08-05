<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form id="adminCreateForm" class="w-[520px] bg-white rounded-lg shadow-lg p-6 relative">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Registrar Nuevo Usuario</h2>

        <!-- Campos -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Nombres</label>
                <input type="text" id="first_name" placeholder="Primer nombre" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Apellidos</label>
                <input type="text" id="last_name" placeholder="Apellidos" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label>Correo Electrónico</label>
                <input type="email" id="email" placeholder="Correo electrónico" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Tipo de Usuario</label>
                <select id="user_type_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    @foreach ($userTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Tipo de Documento</label>
                <select id="document_type_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    @foreach ($documentTypes as $doc)
                        <option value="{{ $doc->id }}">{{ $doc->type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Número de Documento</label>
                <input type="text" id="document_number" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Sexo</label>
                <select id="gender_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Teléfono</label>
                <input type="text" id="phone" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Fecha de Nacimiento</label>
                <input type="date" id="birthdate" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label>Contraseña</label>
                <input type="password" id="password" placeholder="Contraseña" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-6">
            <button type="button" onclick="crearUsuario()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded w-full">
                Crear Usuario
            </button>
            <a href="{{ url('/dashboard/admin') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded w-full text-center">
                Cancelar
            </a>
        </div>

        <div id="errores-validacion" class="space-y-2 mt-4 text-red-600 text-sm"></div>
    </form>

    <script>
        const crearUsuario = async () => {
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
                accepted_terms: true
            };

            try {
                const response = await axios.post(`{{ route('admin.usuarios.store') }}`, data, {
                    headers: { 'Accept': 'application/json' }
                });


                alert('✅ Usuario creado correctamente');
                window.location.href = "{{ route('dashboards.admin') }}";
            } catch (error) {
                const errores = error.response?.data?.errors || {};
                let html = '';
                for (const campo in errores) {
                    errores[campo].forEach(msg => html += `<div>• ${msg}</div>`);
                }
                document.getElementById('errores-validacion').innerHTML = html;
            }
        };
    </script>

</body>
</html>
