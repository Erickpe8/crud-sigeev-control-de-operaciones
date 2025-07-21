<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - FESC</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                </select>
            </div>

            <div>
                <label>Sexo</label>
                <select id="gender" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div>
                <label>Tipo de Documento</label>
                <select id="docType" class="w-full border rounded px-3 py-2">
                    <option value="">Selecciona</option>
                    <option value="cc">Cédula de Ciudadanía</option>
                    <option value="ti">Tarjeta de Identidad</option>
                    <option value="ce">Cédula de Extranjería</option>
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

            <!-- Contraseña -->
            <div class="relative">
                <label>Contraseña</label>
                <input id="password" type="password" placeholder="Password" class="w-full border rounded px-3 py-2 pr-10">
                <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-8 text-gray-500">👁</button>
            </div>

            <!-- Confirmar contraseña -->
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
            <a href="/terminosycondiciones" class="text-red-600 hover:underline">Términos y Condiciones</a> Y la politica de privacidad
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
    </form>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        }
    </script>

    <script>
        const registrar = () => {
            const name = document.getElementById('name').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const country = document.getElementById('country').value;
            const city = document.getElementById('city').value;
            const tipePerson = document.getElementById('tipePerson').value;
            const gender = document.getElementById('gender').value;
            const docType = document.getElementById('docType').value;
            const docNumber = document.getElementById('docNumber').value;
            const phone = document.getElementById('phone').value;
            const birthDate = document.getElementById('birthDate').value;

            console.log({
                name,
                lastName,
                email,
                country,
                city,
                tipePerson,
                gender,
                docType,
                docNumber,
                phone,
                birthDate
            });

            alert(`Nombre: ${name}, Apellido: ${lastName}`);
        };
    </script>

</body>
</html>
