<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - FESC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md overflow-hidden border border-gray-100">

        <!-- Cabecera decorativa -->
        <div class="relative h-6 bg-[#ff0000] mb-6">
            <svg class="absolute top-full left-0 w-full" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,0 C480,100 960,0 1440,100 L1440,0 L0,0 Z"></path>
            </svg>
        </div>

        <!-- Título -->
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">Login FESC</h1>
        </div>

        <!-- Formulario -->
        <div class="px-8 pb-8">
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#ff0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l3-3m-3 3l-3-3"/>
                </svg>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <input id="email" name="email" type="email" required
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#ff0000] focus:border-[#ff0000] pl-10"
                               placeholder="usuario@correo.com">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 12H8m0 0l4-4m-4 4l4 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" required
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#ff0000] focus:border-[#ff0000] pr-10"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-2.5 text-gray-600 hover:text-gray-900 transition-colors duration-200 p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Recordar -->
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" class="form-checkbox text-[#ff0000]">
                        <span>Recuérdame</span>
                    </label>
                    <a href="#" class="text-[#ff0000] hover:underline">¿Olvidó su contraseña?</a>
                </div>

                <!-- Botón -->
                <div>
                    <button type="submit"
                            class="w-full bg-[#ff0000] hover:bg-red-600 text-white py-2 rounded-md font-medium transition duration-200 flex items-center justify-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Ingresar
                    </button>
                </div>
            </form>

            <!-- Registro -->
            <p class="text-center mt-6 text-sm text-gray-700">
                ¿No tienes cuenta?
                <a href="#" class="text-[#ff0000] font-semibold hover:underline">Regístrate ahora</a>
            </p>
        </div>

        <!-- Pie decorativo -->
        <div class="relative h-6 bg-[#ff0000] mt-6">
            <svg class="absolute -top-full left-0 w-full" viewBox="0 0 1440 60" preserveAspectRatio="none">
                <path fill="#ffffff" d="M0,60 C480,0 960,60 1440,0 L1440,60 L0,60 Z"></path>
            </svg>
        </div>

    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById('password');
            pass.type = pass.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
