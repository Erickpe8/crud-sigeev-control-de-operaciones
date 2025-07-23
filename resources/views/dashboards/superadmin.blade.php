<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard para Super Administradores</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Panel de Super Administrador</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition-all duration-300">
                Cerrar sesión
            </button>
        </form>
    </div>
    <div class="bg-white p-4 shadow rounded">
        <p>Bienvenido super administrador, desde aquí puedes gestionar todos los usuarios y roles del sistema.</p>
        <p>Además, tienes la capacidad de editar o eliminar cualquier usuario y asignarles roles específicos.</p>
        <p>Si necesitas realizar alguna gestión adicional, por favor contacta al equipo de soporte.</p>
    </div>
</body>
</html>

