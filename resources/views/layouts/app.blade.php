<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aventones - @yield('title', 'Inicio')</title>

  {{-- CSS/JS compilados por Vite/Tailwind --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" href="{{ asset('assets/css/search-rides-table.css') }}">
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
  @php
    // Pendiente por checar ******************
    // Si usas Auth de Laravel:
    $user = Auth::user() ?? null;
    // o si sigues usando sesion normal:
    // $user = session('user');
  @endphp

  <main class="flex-1 grid place-items-center">
    {{-- contenido de cada página --}}
    @yield('content')
  </main>

  <footer class="mt-auto">
    @include('layouts.footer')
  </footer>

  {{-- Estilos tabla buscar rides--}}
  <link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.umd.js') }}"></script>
</body>

</html>