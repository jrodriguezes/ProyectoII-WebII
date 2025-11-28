@extends('layouts.app')

@section('title', 'Revisa tu correo')

@section('content')
<div class="max-w-md mx-auto text-center py-10">
    <h1 class="text-2xl font-bold mb-2">Revisa tu correo 📬</h1>
    <p>Te enviamos un enlace para verificar tu cuenta. Revisa tu bandeja de entrada y también la carpeta de spam.</p>
    <a href="{{ url('/login') }}" class="hover:text-blue-600">Ir a login</a>
</div>
@endsection
