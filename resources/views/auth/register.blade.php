<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - FESC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form id="registerForm" class="w-[520px] bg-white rounded-lg shadow-lg p-6 relative">

        <!-- Cabecera decorativa -->
        <div class="relative h-6 bg-[#ff0000] rounded-t-lg">
            <svg class="absolute top-full left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,0 C480,100 960,0 1440,100 L1440,0 L0,0 Z"></path>
            </svg>
        </div>

        <!-- Logo y título -->
        <div class="flex justify-center gap-4 mt-4">
            <img src="https://www.fesc.edu.co/portal/images/fesc-30.png" alt="Logo FESC" class="h-12">
            <img src="https://pbs.twimg.com/profile_images/1518692871913807874/hl5lrm-O_400x400.jpg" alt="Logo" class="h-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 text-[#ff0000]" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48...Z" />
            </svg>
        </div>

        <!-- Campos -->
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
                <label>Nombres</label>
                <input type="text" id="name" placeholder="Digite sus nombres" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Apellidos</label>
                <input type="text" id="lastName" placeholder="Digite sus apellidos" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label>Correo Electrónico</label>
                <input type="email" id="email" placeholder="Digite su correo electrónico" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>País</label>
                <input type="text" id="country" placeholder="Digite su país" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Ciudad</label>
                <input type="text" id="city" placeholder="Digite su Ciudad" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Tipo de Persona</label>
                <select id="tipePerson" class="w-full border rounded px-3 py-2">
                    <option>Selecciona</option>
                    <option value="1">Persona Natural</option>
                    <option value="2">Persona Jurídica</option>
                    <option value="3">Entidad Legal o Coorporación</option>
                    <option value="4">Estudiante</option>
                    <option value="5">Gobierno</option>
                </select>
            </div>
            <div>
                <label>Sexo</label>
                <select id="gender" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    <option value="1">Hombre</option>
                    <option value="2">Mujer</option>
                    <option value="3">Prefiero no decir</option>
                    <option value="4">Otro</option>
                </select>
            </div>
            <div>
                <label>Tipo de Documento</label>
                <select id="docType" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    <option value="1">Cédula de Ciudadanía</option>
                    <option value="2">Pasaporte</option>
                    <option value="3">Tarjeta de Identidad</option>
                    <option value="4">Cédula de Extranjería</option>
                    <option value="5">Tarjeta de Residencia</option>
                </select>
            </div>
            <div>
                <label>Número de Documento</label>
                <input id="docNumber" type="text" placeholder="Digite su número de documento" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Teléfono</label>
                <input id="phone" type="text" placeholder="Digite su número de teléfono" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label>Fecha de Nacimiento</label>
                <input id="birthDate" type="date" class="w-full border rounded px-3 py-2">
            </div>
            <div class="relative">
                <label>Contraseña</label>
                <input id="password" type="password" placeholder="Password" class="w-full border rounded px-3 py-2 pr-10">
                <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-8 text-gray-500">👁</button>
            </div>
            <div class="relative">
                <label>Confirmar Contraseña</label>
                <input id="confirm" type="password" placeholder="Confirmar Contraseña" class="w-full border rounded px-3 py-2 pr-10">
                <button type="button" onclick="togglePassword('confirm', this)" class="absolute right-3 top-8 text-gray-500">👁</button>
            </div>
        </div>

        <!-- Aceptar términos -->
        <div class="flex items-center mt-4">
            <input type="checkbox" class="mr-2" checked>
            <span class="text-sm text-red-600">
                Acepto los
                <a href="/terminosycondiciones" class="text-red-600 hover:underline">Términos y Condiciones</a> y la política de privacidad
            </span>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-4">
            <button type="button" onclick="registrar()" class="flex items-center justify-center gap-2 bg-[#ff0000] text-white px-6 py-2 rounded w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                Registrarse
            </button>
            <button type="button" class="flex items-center justify-center gap-2 bg-gray-600 text-white px-6 py-2 rounded w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancelar
            </button>
        </div>

        <!-- Pie decorativo -->
        <div class="relative h-6 mt-6 bg-[#ff0000] rounded-b-lg">
            <svg class="absolute top-0 left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,100 C480,0 960,100 1440,0 L1440,100 L0,100 Z"></path>
            </svg>
        </div>

        <div id="errores-validacion" class="space-y-2 my-4"></div>
    </form>

    <div id="alert-container" class="fixed top-4 right-4 z-50 space-y-4"></div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }
    </script>


    <script>
    const registrar = async () => {
        limpiarErrores();

        const formData = {
            first_name: document.getElementById('name').value,
            last_name: document.getElementById('lastName').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            confirm_password: document.getElementById('confirm').value,
            country: document.getElementById('country').value,
            city: document.getElementById('city').value,
            user_type_id: document.getElementById('tipePerson').value,
            gender_id: document.getElementById('gender').value,
            document_type_id: document.getElementById('docType').value,
            document_number: document.getElementById('docNumber').value,
            phone: document.getElementById('phone').value,
            birthdate: document.getElementById('birthDate').value,
            accepted_terms: true
        };

        if (formData.password !== formData.confirm_password) {
            showAlert('error', 'Las contraseñas no coinciden');
            return;
        }

        try {
            const response = await axios.post('/api/registrar', formData);

            showAlert('info', 'Usuario registrado exitosamente');
            document.getElementById('registerForm').reset();
        } catch (error) {
            const errData = error.response?.data || error.message || error;

            if (error.response?.status === 422) {
                const errores = errData.errors || {};
                Object.entries(errores).forEach(([campo, mensajes]) => {
                    mensajes.forEach(mensaje => {
                        showAlert('error', mensaje);
                    });
                });
            } else if (error.response?.status === 400) {
                showAlert('error', 'Error en la solicitud. Revisa los campos.');
            } else {
                showAlert('error', 'Error inesperado. Intenta más tarde.');
            }
        }
    };

    const limpiarErrores = () => {
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.classList.remove('border-red-500', 'ring', 'ring-red-300');
        });
    };

    const showAlert = (type = 'info', message = '') => {
        const alertId = `alert-${Date.now()}`;
        const color = type === 'error'
            ? { bg: 'bg-red-100', text: 'text-red-800', border: 'border-red-400' }
            : { bg: 'bg-green-100', text: 'text-green-800', border: 'border-green-400' };

        const div = document.createElement('div');
        div.id = alertId;
        div.className = `p-4 rounded shadow border-l-4 w-96 ${color.bg} ${color.text} ${color.border}`;
        div.innerHTML = `
            <div class="flex items-start">
                <svg class="w-5 h-5 mt-1 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-10H9v4h2V8zm0 6H9v2h2v-2z" />
                </svg>
                <div class="text-sm">${message}</div>
            </div>
        `;

        const container = document.getElementById('alert-container');
        container.appendChild(div);

        setTimeout(() => {
            const el = document.getElementById(alertId);
            if (el) el.remove();
        }, 5000);
    };
    </script>
</body>
</html>
