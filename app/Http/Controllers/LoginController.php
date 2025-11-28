<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $creedentials = $request->validate([
            'floating_email' => 'required|email',
            'floating_password' => 'required|string',
        ]);

        $user = User::where('email', $creedentials['floating_email'])->first();

        if (!$user || !Hash::check($creedentials['floating_password'], $user->password)) {
            return back()->withErrors([
                'floating_email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->withInput($request->only('floating_email'));
        }// para que no borre el email del form

        if ($user->status !== 'active') {
            return back()->withErrors([
                'email' => 'Tu cuenta no está activa. Por favor, verifica tu correo electrónico.',
            ]);
        }

        Auth::login($user);
        return redirect()->route('home');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
?>