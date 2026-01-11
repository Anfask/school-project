<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - Admission Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <nav class="bg-white shadow">
        <div class="container-fluid px-4 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-blue-600">Admin Dashboard</div>
            <div class="flex items-center gap-6">
                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white min-h-screen">
            <div class="p-6 border-b border-blue-800">
                <h2 class="text-lg font-bold">Menu</h2>
            </div>
            <ul class="p-4 space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-blue-800' : '' }}">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.applications') }}" class="block px-4 py-2 rounded hover:bg-blue-800 {{ Route::currentRouteName() === 'admin.applications' ? 'bg-blue-800' : '' }}">
                        📋 Applications
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>
