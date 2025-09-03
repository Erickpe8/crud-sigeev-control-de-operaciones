@extends('layouts.panel', ['title' => 'Panel Central', 'brand' => 'Panel Central'])

@section('content')
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-100">¿Qué deseas hacer?</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Selecciona un módulo para continuar.</p>
        </div>
        <div class="w-full sm:w-72">
            <label for="moduleSearch" class="sr-only">Buscar módulo</label>
            <input id="moduleSearch" type="search" placeholder="Buscar módulo…"
                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>

    @if(!empty($modules))
        <div id="modulesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $module)
                <a href="{{ route($module['route']) }}"
                    class="module-card group flex flex-col p-5 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-transform duration-200 hover:-translate-y-0.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                    data-title="{{ Str::lower($module['title']) }}" data-desc="{{ Str::lower($module['description'] ?? '') }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="text-indigo-600 dark:text-indigo-400 shrink-0">
                            {!! $module['icon'] ?? '<svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" /></svg>' !!}
                        </div>
                        @if(!empty($module['badge']))
                            <span
                                class="ml-3 inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-300">
                                {{ $module['badge'] }}
                            </span>
                        @endif
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $module['title'] }}</h3>
                    @if(!empty($module['description']))
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">{{ $module['description'] }}</p>
                    @endif
                    <div class="mt-4 flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400">
                        Ir al módulo
                        <svg class="ml-1.5 h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="font-medium">No tienes módulos disponibles</span>
            <p>Por favor, contacta con el administrador para obtener acceso a los módulos.</p>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
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
@endpush
