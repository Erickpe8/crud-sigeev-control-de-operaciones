{{-- resources/views/users/index.blade.php --}}
@extends('layouts.panel')

@push('head')
    {{-- simple-datatables (CSS) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div id="infoPanel" class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Gestión de Usuarios</h1>

        {{-- Mensaje de bienvenida --}}
        <div id="mensajeBienvenida" class="bg-white p-4 shadow rounded mb-6">
            <p class="text-gray-700 leading-relaxed">
                Bienvenido, Administrador. Desde este panel tienes acceso completo para visualizar, editar, registrar y
                eliminar usuarios dentro del sistema, con excepción de los usuarios con rol
                <strong>Superadministrador</strong>, cuya gestión está reservada por razones de seguridad.
                <br><br>
                Asegúrate de verificar cuidadosamente la información antes de aplicar cambios, ya que estos pueden afectar
                el acceso y los permisos de los usuarios.
                <br><br>
                Si necesitas realizar acciones avanzadas, como la gestión de roles especiales o restaurar cuentas
                eliminadas, por favor comunícate con el equipo de soporte técnico a través de los canales oficiales.
            </p>
        </div>

        {{-- Tabla de usuarios --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="usuarios-table" class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr class="text-gray-600 uppercase text-xs tracking-wider">
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse(($users ?? collect()) as $usuario)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-2">
                                                        {{ $usuario->first_name }} {{ $usuario->last_name }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $usuario->email }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $usuario->roles->pluck('name')->implode(', ') ?: 'sin rol' }}
                                                    </td>
                        <td class="px-4 py-2">
                            <div class="flex items-center justify-center gap-4">
                                @can('users.manage')
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('usuarios.show', $usuario) }}" class="px-4 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md
                                                  hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400
                                                  focus:ring-offset-1 transition flex-none">
                                        Editar
                                    </a>
                                @endcan

                                @php $isSuperAdmin = $usuario->hasRole('superadmin'); @endphp
                                @if(!$isSuperAdmin && auth()->user()->can('users.delete'))
                                    {{-- Botón Eliminar --}}
                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                        onsubmit="return confirm('¿Eliminar este usuario?')" class="flex-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-1.5 text-sm font-medium text-white bg-red-600 rounded-md
                                                           hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400
                                                           focus:ring-offset-1 transition">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>

                                                </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No hay usuarios para mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- simple-datatables (JS) --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('usuarios-table');
            if (!el || typeof simpleDatatables === 'undefined') return;

            new simpleDatatables.DataTable(el, {
                perPage: 10,
                searchable: true,
                fixedHeight: false,
                labels: {
                    perPage: '{select} por página',
                    noRows: 'No se encontraron registros',
                    info: 'Mostrando {start}–{end} de {rows}'
                }
            });
        });
    </script>
@endpush
