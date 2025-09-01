<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel Central</title>
        @vite('resources/css/app.css')
    <style>
        /* Evitar scroll horizontal en layouts pequeños */
        html, body { overflow-x: hidden; }
        /* Respeta usuarios con reduced motion */
        @media (prefers-reduced-motion: reduce) {
            * {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
            scroll-behavior: auto !important;
            }
        }
    </style>
    </head>
<body class="h-full antialiased">
    {{-- NAVBAR --}}
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button
                id="sidebarToggleBtn"
                data-drawer-target="logo-sidebar"
                data-drawer-toggle="logo-sidebar"
                aria-controls="logo-sidebar"
                type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                >
                <span class="sr-only">Abrir menú lateral</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
                </button>

                <a href="#" class="flex ms-2 md:me-24">
                <img src="{{ asset('favicon.png') }}" class="h-8 me-3" alt="Logo" />
                <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                    Panel Central
                </span>
                </a>
            </div>

        <div class="flex items-center">
                <div class="hidden sm:block mr-4 text-sm text-gray-700 dark:text-gray-300">
                {{ $user->name }}
                </div>

                <div class="flex items-center ms-3 relative">
                <div>
                    <button
                        id="userMenuBtn"
                        type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        aria-expanded="false"
                        aria-haspopup="true"
                        data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Abrir menú de usuario</span>
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->photo_url
                                ? asset('storage/' . $user->photo_url)
                                : asset('images/default-avatar.png') }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';" alt="Foto de perfil">
                    </button>
                </div>

                <div
                    id="dropdown-user"
                    class="absolute right-0 top-12 z-50 hidden w-48 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                    role="menu" aria-labelledby="userMenuBtn">
                    <div class="px-4 py-3">
                    <p class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                    <p class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                        {{ $user->email }}
                    </p>
                    </div>
                    <ul class="py-1">
                    <li>
                        <a href="{{ route('panel') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Panel</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit', auth()->user()->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Editar Perfil</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Cerrar sesión
                        </button>
                        </form>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        </div>
    </nav>

    {{-- ASIDE --}}
        <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar"
        >
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('panel') }}" class="flex items-center p-2 rounded-lg text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                    <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                    <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                </svg>
                <span class="ms-3">Panel</span>
                </a>
            </li>
            </ul>
        </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="p-4 sm:ml-64">
            <div class="p-4 mt-14 border border-dashed border-gray-200 rounded-lg dark:border-gray-700">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-100">¿Qué deseas hacer?</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Selecciona un módulo para continuar.</p>
                    </div>
                    <div class="w-full sm:w-72">
                        <label for="moduleSearch" class="sr-only">Buscar módulo</label>
                        <input
                            id="moduleSearch"
                            type="search"
                            placeholder="Buscar módulo…"
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                </div>

                @if(!empty($modules) && count($modules) > 0)
                    <div id="modulesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($modules as $module)
                            <a
                                href="{{ route($module['route']) }}"
                                class="module-card group flex flex-col p-5 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-transform duration-200 hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                                data-title="{{ Str::lower($module['title']) }}"
                                data-desc="{{ Str::lower($module['description'] ?? '') }}"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div class="text-indigo-600 dark:text-indigo-400 shrink-0">
                                        {!! $module['icon'] ?? '<svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" /></svg>' !!}
                                    </div>

                                    @if(!empty($module['badge']))
                                        <span class="ml-3 inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-300">
                                            {{ $module['badge'] }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                    {{ $module['title'] }}
                                </h3>

                                @if(!empty($module['description']))
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                        {{ $module['description'] }}
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                    Ir al módulo
                                    <svg class="ml-1.5 h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Mostrar alerta si no hay módulos disponibles -->
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Danger</span>
                        <div>
                            <span class="font-medium">No tienes módulos disponibles</span>
                            <p>Por favor, contacta con el administrador para obtener acceso a los módulos.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    {{-- AQUI TERMINA LO DE MOSTRAR LOS MODULOS --}}
<script>
    // Asegura el tema oscuro desde localStorage
    (function ensureDarkFromLocalStorage() {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();

    // Función para controlar el toggle del sidebar
    (function sidebarToggle() {
        const btn = document.getElementById('sidebarToggleBtn');
        const aside = document.getElementById('logo-sidebar');
        if (!btn || !aside) return;
        btn.addEventListener('click', () => {
            const isHidden = aside.classList.contains('-translate-x-full');
            aside.classList.toggle('-translate-x-full', !isHidden);
        });
    })();

    // Escuchar clicks fuera del menú para cerrarlo
    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !trigger.contains(e.target)) close();
    });

    // Escuchar la tecla "Escape" para cerrar
    document.addEventListener('DOMContentLoaded', function () {
        const menu = document.getElementById('logo-sidebar');  // El ID correcto del sidebar
        const trigger = document.getElementById('sidebarToggleBtn');  // El ID correcto del botón de apertura

        // Asegúrate de que los elementos existen antes de agregar el event listener
        if (menu && trigger) {
            trigger.addEventListener('click', () => {
                // Alternar la clase para mostrar/ocultar el menú
                menu.classList.toggle('-translate-x-full');  // Esta clase oculta o muestra el menú
            });

            // Escuchar clics fuera del menú para cerrarlo
            document.addEventListener('click', (e) => {
                // Comprobar si el clic ocurrió fuera del menú y el botón de apertura
                if (!menu.contains(e.target) && !trigger.contains(e.target)) {
                    menu.classList.add('-translate-x-full');  // Cierra el menú añadiendo la clase que lo oculta
                }
            });
        } else {
            console.error("No se encontraron los elementos con los IDs proporcionados.");
        }
    });


    // Filtro rápido de módulos
    (function quickFilter() {
        const input = document.getElementById('moduleSearch');
        const cards = Array.from(document.querySelectorAll('.module-card'));

        if (!input || !cards.length) return;

        input.addEventListener('input', () => {
            const q = input.value.trim().toLowerCase();
            cards.forEach(card => {
                const title = card.getAttribute('data-title') || '';
                const desc = card.getAttribute('data-desc') || '';
                const match = !q || title.includes(q) || desc.includes(q);
                card.classList.toggle('hidden', !match);
            });
        });
    })();
</script>

<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

    </body>
</html>
