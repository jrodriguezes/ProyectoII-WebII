<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Aventones')</title>

    {{-- tus CSS --}}
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search-rides-table.css') }}">
    <link rel="icon" href="data:,">


    <script>
        const stored = localStorage.getItem('color-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (stored === 'dark' || (!stored && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-100 overflow-x-hidden">
    {{-- aquí podrías leer session('user') si lo necesitas --}}
    @includeIf('layouts.navbar')

    <main class="flex-1 grid place-items-center">
        @yield('content') {{-- AQUÍ SE INYECTA EL CONTENIDO DE CADA PÁGINA --}}
    </main>

    <footer class="mt-auto">
        @includeIf('layouts.footer')
    </footer>

    {{-- JS --}}
    <script src="{{ asset('assets/js/theme-toggle.js') }}"></script>
    <script src="{{ asset('assets/js/toggle-user-type.js') }}"></script>
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.umd.js') }}"></script>
    <script src="{{ asset('assets/js/filter-table.js') }}"></script>
</body>

</html>