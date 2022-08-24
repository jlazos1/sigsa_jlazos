<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('provider_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                $permisos = DB::table('permissions')
                    ->join('roles', 'roles.id', '=', 'permissions.rol_id')
                    ->select('permissions.*', 'roles.name')
                    ->where('permissions.user_id', Auth::id())
                    ->where('status', 1)
                    ->get();

                foreach ($permisos as $perm) {
                    session()->put($perm->name, $perm->rol_id);
                }

                return redirect()->intended('/');
            } else {
                $newUser = new User();
                $newUser->name =  $user->name;
                $newUser->email =  $user->email;
                $newUser->provider =  "google";
                $newUser->provider_id =  $user->id;
                $newUser->save();

                $permiso = new Permission();
                $permiso->user_id = $newUser->id;
                $permiso->rol_id = 1;
                $permiso->status = 1;
                $permiso->save();

                //Auth::login($newUser);

                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
