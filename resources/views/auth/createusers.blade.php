<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 py-8">
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Registrar Nuevo Usuario</h2>

    <form id="adminCreateForm" class="grid gap-6">

        <!-- Datos personales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label>Nombres</label>
                <input type="text" id="first_name" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Apellidos</label>
                <input type="text" id="last_name" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Correo Electrónico</label>
                <input type="email" id="email" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <!-- Documento y tipo -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label>Tipo de Usuario</label>
                <select id="user_type_id" class="w-full border rounded px-3 py-2" onchange="toggleCamposEspeciales()">
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
        </div>

        <!-- Datos adicionales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
        </div>

        <!-- Contraseña -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label>Contraseña</label>
                <input type="password" id="password" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <!-- Campos académicos -->
        <div id="academic_section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 hidden">
            <div>
                <label>Programa Académico</label>
                <select id="academic_program_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    @foreach ($academicPrograms as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Institución</label>
                <select id="institution_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    @foreach ($institutions as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Campos empresariales -->
        <div id="empresa_section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 hidden">
            <div>
                <label>Nombre de la Empresa</label>
                <input type="text" id="company_name" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Dirección de la Empresa</label>
                <input type="text" id="company_address" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <!-- Botones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button type="button" onclick="crearUsuario()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded w-full">
                Crear Usuario
            </button>
            <a href="{{ url('/dashboard/admin') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded w-full text-center">
                Cancelar
            </a>
        </div>

        <div id="errores-validacion" class="space-y-2 mt-2 text-red-600 text-sm col-span-full"></div>
    </form>
</div>

<script>
    function toggleCamposEspeciales() {
        const tipo = parseInt(document.getElementById('user_type_id').value);
        document.getElementById('academic_section').classList.toggle('hidden', tipo !== 4);
        document.getElementById('empresa_section').classList.toggle('hidden', !(tipo === 2 || tipo === 3));
    }

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
            academic_program_id: document.getElementById('academic_program_id')?.value || null,
            institution_id: document.getElementById('institution_id')?.value || null,
            company_name: document.getElementById('company_name')?.value || null,
            company_address: document.getElementById('company_address')?.value || null,
            accepted_terms: true
        };

        try {
            await axios.get('/sanctum/csrf-cookie');

            const response = await axios.post(`{{ route('admin.usuarios.store') }}`, data, {
                headers: { 'Accept': 'application/json' },
                withCredentials: true
            });

            const continuar = confirm("✅ Usuario creado correctamente.\n\n¿Deseas crear otro usuario?");
            if (continuar) {
                document.getElementById('adminCreateForm').reset();
                toggleCamposEspeciales();
                document.getElementById('first_name').focus();
            } else {
                window.location.href = "{{ url('/dashboard/admin') }}";
            }
        } catch (error) {
            const errores = error.response?.data?.errors || {};
            let html = '';
            for (const campo in errores) {
                errores[campo].forEach(msg => html += `<div>• ${msg}</div>`);
            }
            document.getElementById('errores-validacion').innerHTML = html;
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        toggleCamposEspeciales();
        document.getElementById('first_name').focus();
    });
</script>

</body>
</html>
