<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class authController extends Controller
{


    //index adalah halaman view utama frontend
    function index(){
        return view('auth.index');
    }


    //redirect login with google
    function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    function callback()
    {


        $user = Socialite::driver('google')->user();

        // referensi: https://laravel.com/docs/9.x/socialite
        $id = $user->id;
        $email = $user->email;
        $name = $user->name;

         //cek email apakah sesuai yg diizinkan atau tidak
         $cek = User::where('email', $email)->count();
         if ($cek > 0) {
             $user = User::updateOrCreate(
                 ['email' => $email],
                 [
                     'name' => $name,
                     'google_id' => $id
                 ]
             );

             Auth::login($user);
             return redirect()->to('dashboard');
         } else {
            return redirect()->to('auth')->with('error', 'akun anda tidak terdaftar');
         }
    }



    public function logout(){
        Auth::Logout();
        return redirect()->to('auth');
    }
}
