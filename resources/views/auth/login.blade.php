<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - FESC</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
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

        <div class="px-8 pb-8">
            <!-- Icono -->
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#ff0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l3-3m-3 3l-3-3"/>
                </svg>
            </div>

            <!-- Alertas -->
            <div id="alertContainer" class="mt-4 space-y-3">
                @if (session('status'))
                    <div class="alert-item flex p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <svg class="shrink-0 inline w-5 h-5 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 0 0-1.414 0L9 11.586 6.707 9.293a1 1 0 1 0-1.414 1.414l3 3a1 1 0 0 0 1.414 0l7-7a1 1 0 0 0 0-1.414z"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-item flex p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="shrink-0 inline w-5 h-5 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-item flex p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="shrink-0 inline w-5 h-5 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div>
                            <span class="font-medium">Se encontraron los siguientes errores:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 mt-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <input id="email" name="email" type="email" required autocomplete="email"
                            value="{{ old('email') }}"
                            class="block w-full rounded-lg border border-gray-300 px-10 py-2 shadow-sm focus:ring-2 focus:ring-[#ff0000] focus:border-[#ff0000] outline-none"
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
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:ring-2 focus:ring-[#ff0000] focus:border-[#ff0000] outline-none pr-10"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-2.5 text-gray-600 hover:text-gray-900 transition-colors duration-200 p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500"
                                aria-label="Mostrar u ocultar contraseña">
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
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#ff0000] focus:ring-[#ff0000]">
                        <span>Recuérdame</span>
                    </label>
                    {{-- <a href="{{ route('password.request') }}" class="text-[#ff0000] hover:underline">¿Olvidó su contraseña?</a> --}}
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
                <a href="{{ route('register') }}" class="text-[#ff0000] font-semibold hover:underline">Regístrate ahora</a>
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

        // Ocultar alertas suavemente
        document.addEventListener("DOMContentLoaded", () => {
            const alerts = document.querySelectorAll("#alertContainer .alert-item");
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add("opacity-0", "transition-opacity", "duration-500");
                    setTimeout(() => alert.remove(), 500);
                }, 4000); // 4s visibles
            });
        });
    </script>
</body>
</html>
