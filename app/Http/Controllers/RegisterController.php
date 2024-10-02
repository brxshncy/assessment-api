<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.xxp
     */

    public function __invoke(RegisterPostRequest $request)
    {
        $role = Role::where('name', $request->role)
                      ->first();

        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->except(['role']));
        $user->assignRole($role);
        return response()->success(
            $user->load('roles'), 203
        );
    }
}
