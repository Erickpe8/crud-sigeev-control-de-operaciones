<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard para administradores</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Panel de Administrador</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition-all duration-300"
            >
                Cerrar sesión
            </button>
        </form>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <p>Bienvenido administrador, desde aquí puedes gestionar usuarios y editar roles, a excepción del super administrador.</p>
    </div>

</body>
</html>
