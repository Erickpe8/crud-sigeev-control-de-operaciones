@props([
    'user' => null,
    'brand' => 'Panel',
])

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button
                    id="sidebarToggleBtn"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="logo-sidebar" aria-expanded="false" aria-label="Abrir menú lateral">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>

                <a href="{{ route('panel') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('favicon.png') }}" class="h-8 me-3" alt="Logo" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                        {{ $brand }}
                    </span>
                </a>
            </div>

            <div class="flex items-center">
                @if($user)
                    <div class="hidden sm:block mr-4 text-sm text-gray-700 dark:text-gray-300">
                        {{ $user->name }}
                    </div>
                @endif

                <div class="flex items-center ms-3 relative">
                    <button
                        id="userMenuBtn"
                        type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        aria-expanded="false"
                        aria-haspopup="true"
                        data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Abrir menú de usuario</span>
                        <img class="w-8 h-8 rounded-full object-cover"
                             src="{{ ($user && $user->profile_photo) ? asset('storage/' . $user->profile_photo) : asset('images/default-avatar.png') }}"
                             onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';"
                             alt="Foto de perfil">
                    </button>

                    <div id="dropdown-user"
                         class="absolute right-0 top-12 z-50 hidden w-48 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                         role="menu" aria-labelledby="userMenuBtn">
                        <div class="px-4 py-3">
                            @if($user)
                                <p class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="block px-0 py-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $user->email }}
                                </p>
                            @endif
                        </div>
                        <ul class="py-1">
                            <li>
                                <a href="{{ route('panel') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Panel</a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit', auth()->id()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">Editar Perfil</a>
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
