@php
    // Obtener usuario desde la sesión Laravel
    $user = session('user');

    // Si no hay usuario, dejamos valores por defecto
    $imgUrl = $user['profile_photo'] ?? 'https://flowbite.com/docs/images/people/profile-picture-5.jpg';

    // URL limpia
    $imgUrl = htmlspecialchars($imgUrl);

    // Página actual para resaltar el menú
    $current_page = request()->path();
@endphp

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/home" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Aventones</span>
        </a>

        <!-- Si NO hay usuario logueado, mostrar botón Login -->
        @if(!$user)
            <a href="/login"
               class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                Login
            </a>
        @endif

        @if($user)
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <button type="button"
                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="{{ $imgUrl }}" alt="user photo">
            </button>

            <div id="user-dropdown"
                class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ $user['first_name'] }}</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ $user['email'] }}</span>
                </div>
                <ul class="py-2">
                    <li>
                        <a href="/edit-profile"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            Settings
                        </a>
                    </li>
                    <li>
                        <form action="/post/logout.php" method="POST">
                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        @endif

            <!-- botón hamburguesa -->
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        @if($user)
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 dark:border-gray-700">
                
                <li>
                    <a href="/home"
                       class="block py-2 px-3 {{ request()->is('home') ? 'text-blue-700' : 'text-gray-900' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="/booking"
                       class="block py-2 px-3 {{ request()->is('booking') ? 'text-blue-700' : 'text-gray-900' }}">
                        Bookings
                    </a>
                </li>

            </ul>
        </div>
        @endif
    </div>
</nav>
