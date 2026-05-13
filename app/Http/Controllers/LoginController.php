<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenggunaModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = PenggunaModel::where('username', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            Session::put('loginId', $user->id_pengguna);
            return redirect('/home')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('pengguna');
        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    public function lupapassword()
    {
        return view('login.lupapassword');

    }

    public function kirimLinkReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with(
            'success',
            'Jika email terdaftar, link reset password akan dikirim.'
        );
    }


    public function formResetPassword(Request $request, $token)
    {
        return view('login.reset_password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                //$user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/')->with('success', 'Password berhasil direset. Silakan login.')
            : back()->withErrors(['email' => __($status)]);
    }

}