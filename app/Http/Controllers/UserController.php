<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update($request->all());

        return redirect()->route('userIndex')->with('success', 'Usuario actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function savePermissions(Request $request)
    {
        $input = $request->all();
        $input['permisos'] = $request->input('permisos');
        $user = $request->input('user');
        if ($input['permisos'] == null) {
            for ($i = 0; $i < 5; $i++) {
                if ($this->comprobarRol($user, $i + 1)) {
                    $this->removePermission($user, $i + 1);
                }
            }
        } else {
            for ($i = 0; $i < 5; $i++) {
                if (array_search($i + 1, $input['permisos']) == false) {
                    if ($this->comprobarRol($user, $i + 1)) {
                        $this->removePermission($user, $i + 1);
                    }
                }
            }

            foreach ($input['permisos'] as $perm) {
                $this->setPermission($user, $perm);
            }
        }

        return redirect()->route('userIndex');
    }

    public function getPermission($user_id)
    {
        $roles = Role::all();
        $permisos = Permission::where('user_id', $user_id)
            ->where('status', 1)
            ->get();

        $user = User::where('id', $user_id)->first();

        return view('users.permissions', compact('permisos', 'user', 'roles'));
    }

    public function setPermission($user_id, $rol_id)
    {
        $permiso = Permission::where('user_id', $user_id)
            ->where('rol_id', $rol_id)
            ->first();
        if ($permiso == null) {
            $nuevo = new Permission();
            $nuevo->user_id = $user_id;
            $nuevo->rol_id = $rol_id;
            $nuevo->status = 1;
            $nuevo->save();
        } else {
            $permiso->status = 1;
            $permiso->save();
        }
    }

    public function comprobarRol($user_id, $rol_id)
    {
        $permiso = Permission::where('user_id', $user_id)
            ->where('rol_id', $rol_id)
            ->first();
        if ($permiso != null) {
            if ($permiso->status == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function removePermission($user_id, $rol_id)
    {
        $permiso = Permission::where('user_id', $user_id)
            ->where('rol_id', $rol_id)
            ->first();

        $permiso->status = 0;
        $permiso->save();
    }
}
