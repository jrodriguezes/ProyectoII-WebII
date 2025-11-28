@extends('layouts.app')

@section('title', 'Cuenta verificada')

@section('content')
<div class="max-w-md mx-auto text-center py-12">

    <h1 class="text-3xl font-bold mb-4 text-green-600">
        ¡Tu cuenta ha sido verificada!
    </h1>

    <p class="text-gray-700 dark:text-gray-300 mb-6">
        Gracias por confirmar tu correo electrónico.  
        Ya puedes iniciar sesión y comenzar a usar Aventones.
    </p>

    <a href="{{ route('login') }}"
        class="inline-block px-6 py-3 text-white bg-blue-700 hover:bg-blue-800 
        rounded-lg font-medium shadow-sm transition">
        Ir al login
    </a>

</div>
@endsection
