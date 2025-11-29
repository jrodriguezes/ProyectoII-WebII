<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
       
        // validar datos
        $data = $request->validate([
            'floating_id' => 'string|unique:users,id',
            'floating_first_name' => 'string|max:50',
            'floating_last_name' => 'string|max:50',
            'date' => 'date',
            'floating_email' => 'email|max:100|unique:users,email',
            'floating_phone' => 'string|max:20',
            'user_type' => 'string|max:40',
            'floating_password' => 'string|min:4',
            'floating_repeat_password' => 'string|min:4|same:floating_password',
            'photo' => 'nullable|image|max:2048', // 2 MB
        ]);

        // subir foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // guarda en storage/app/public/profile_photos
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }

        // token de verificacion 
        $token = Str::random(64);
        $verifyHash = hash('sha256', $token);
        $verifyExpiresAt = now()->addHours(24);

        // crear usuario 
        $user = User::create([
            'id' => $data['floating_id'],
            'first_name' => $data['floating_first_name'],
            'last_name' => $data['floating_last_name'],
            'birth_date' => $data['date'],
            'email' => $data['floating_email'],
            'phone_number' => $data['floating_phone'],
            'profile_photo' => $photoPath,
            'password' => Hash::make($data['floating_password']),
            'user_type' => $data['user_type'],
            'status' => 'pending',
            'verify_token_hash' => $verifyHash,
            'verify_token_expires_at' => $verifyExpiresAt,
        ]);

       

        // enviar correo de verificacion
        $verifyUrl = route('verify.email', [
            'uid' => $user->id,
            'token' => $token,
        ]);

        // simple con Mail::raw
        try {
            Mail::raw(
                "Hola {$user->first_name}, verifica tu correo entrando aqui: {$verifyUrl}",
                function ($message) use ($user) {
                    $message->to($user->email, "{$user->first_name} {$user->last_name}")
                        ->subject('Verifica tu correo - Aventones');
                }
            );
        } catch (\Throwable $e) {
            // no reventar la app si el mail falla, solo loguear
            logger()->error('Mailer error: ' . $e->getMessage());
        }

        // redirigir (equivalente a header("Location: /check-your-email"))
        return redirect('/check-email');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // validar datos 
        $data = $request->validate([
            'floating_first_name' => 'string|max:50',
            'floating_last_name' => 'string|max:50',
            'date' => 'date',
            'floating_phone' => 'string|max:20',
            'user_type' => 'string|max:40',
            'floating_password' => 'string|min:4',
            'floating_repeat_password' => 'string|min:4|same:floating_password',
            'photo' => 'image|max:2048',
        ]);

        // actualizar campos 
        $user->first_name = $data['floating_first_name'];
        $user->last_name = $data['floating_last_name'];
        $user->birth_date = $data['date'];
        $user->phone_number = $data['floating_phone'];
        $user->user_type = $data['user_type'];

        //  foto nueva (opcional)
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo = $photoPath;
        }

        // actualizar password solo si viene una nueva
        if (!empty($data['floating_password'])) {
            $user->password = Hash::make($data['floating_password']);
        }

        $user->save();

        Auth::logout();
        return redirect()->route('login');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // si el que se borra es el usuario logueado:
        if (Auth::id() === $user->id) {
            Auth::logout();
        }

        return redirect()->route('home')->with('status', 'Usuario eliminado correctamente');
    }

    public function verify(Request $request)
    {
        $uid = $request->query('uid');
        $token = $request->query('token');

        $hash = hash('sha256', $token);

        $user = User::find($uid);
        if (!$user) {
            exit('Usuario no encontrado');
        }

        if ($user->status !== 'pending') {
            return redirect()->route('login');
        }

        if ($user->verify_token_hash !== $hash || $user->verify_token_expires_at < now()) {
            exit('El enlace es inválido o ha expirado');
        }

        $user->status = 'active';
        $user->email_verified_at = now();
        $user->verify_token_hash = null;
        $user->verify_token_expires_at = null;
        $user->save();
        return view('email-verified');
    }

}
