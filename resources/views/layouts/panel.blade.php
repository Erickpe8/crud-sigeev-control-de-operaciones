<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100 dark:bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel Central' }}</title>
    @vite('resources/css/app.css')
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
    @stack('head')
</head>

<body class="h-full antialiased">
    {{-- NAVBAR --}}
    <x-navbar :user="$user ?? auth()->user()" :brand="$brand ?? 'Panel Central'" />

    {{-- ASIDE --}}
    <x-sidebar :items="$sidebarItems ?? []" id="logo-sidebar" />

    {{-- CONTENIDO --}}
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14 border border-dashed border-gray-200 rounded-lg dark:border-gray-700">
            @yield('content')
        </div>
    </div>

    {{-- JS mínimo y accesible --}}
    <script>
        (function ensureDarkFromLocalStorage() {
            if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
        })();

        (function sidebarToggle() {
            const btn = document.getElementById('sidebarToggleBtn');
            const aside = document.getElementById('logo-sidebar');
            if (!btn || !aside) return;

            const closeIfClickOutside = (e) => {
                if (!aside.contains(e.target) && !btn.contains(e.target)) {
                    aside.classList.add('-translate-x-full');
                }
            };

            btn.addEventListener('click', () => {
                aside.classList.toggle('-translate-x-full');
            });
            document.addEventListener('click', closeIfClickOutside);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') aside.classList.add('-translate-x-full');
            });
        })();
    </script>

    @stack('scripts')
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>

</html>
