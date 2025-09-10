@props([
    'items' => [],
    'id' => 'logo-sidebar',
])

<aside id="{{ $id }}"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @forelse ($items as $item)
                @php
                    $isActive = isset($item['route']) ? request()->routeIs($item['route']) : false;
                @endphp
                <li>
                    <a href="{{ isset($item['route']) ? route($item['route']) : ($item['href'] ?? '#') }}"
                       class="flex items-center p-2 rounded-lg
                              {{ $isActive ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700' }}
                              group focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        <span class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            {!! $item['icon'] ?? '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 22 21"><circle cx="11" cy="11" r="9"/></svg>' !!}
                        </span>
                        <span class="ms-3">{{ $item['label'] ?? 'Item' }}</span>
                    </a>
                </li>
            @empty
                <li class="text-sm text-gray-500 dark:text-gray-400 px-2">Sin items</li>
            @endforelse
        </ul>
    </div>
</aside>
