<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MagicLoginToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MagicLoginController extends Controller
{
    // el usuario pide que le manden el link
    public function sendLink(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $data['email'])->where('status', 'active')->first();

        // generar token
        $plainToken = Str::random(64);
        $hash = hash('sha256', $plainToken);

        // guardar en BD
        MagicLoginToken::create([
            'user_id' => $user->id,
            'token_hash' => $hash,
            'expires_at' => now()->addMinutes(3600),
        ]);

        // armar URL
        $url = route('magic.login', ['token' => $plainToken]);

        // enviar correo simple
        try {
            Mail::raw(
                "Hola {$user->first_name}, entra a tu cuenta usando este enlace (valido 1 hora y de un solo uso): {$url}",
                function ($message) use ($user) {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Acceso sin contraseña - Aventones');
                }
            );
        } catch (\Throwable $e) {
            logger()->error('Mailer error (magic login): ' . $e->getMessage());
        }

        return back()->with('status', 'Si el correo existe, se envió un link de acceso.');
    }

    // el usuario hace click en el link
    public function loginWithLink(string $token)
    {
        $hash = hash('sha256', $token);

        $record = MagicLoginToken::where('token_hash', $hash)->first();

        if (
            !$record ||
            $record->used_at !== null || // ya se uso
            $record->expires_at->isPast() // ya expiro
        ) {
            abort(403, 'Este enlace no es válido o ha expirado.');
        }

        $user = $record->user;

        if (!$user || $user->status !== 'active') {
            abort(403, 'Usuario no válido.');
        }

        // marcar como usado (de un solo uso)
        $record->used_at = now();
        $record->save();

        // loguear al usuario
        Auth::login($user);

        return redirect()->route('home')->with('status', 'Has iniciado sesión con el enlace mágico.');
    }

    
}
