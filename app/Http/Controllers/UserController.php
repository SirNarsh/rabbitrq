<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Permission;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        if (User::count() > 0) {
            // Only check permissions after first user creation (App Setup)
            $this->authorizeResource(User::class);
        }

    }

    /**
     *
     * @param UserCreateRequest $request
     * @return User
     */
    public function store(UserCreateRequest $request)
    {
        $hashedPwd = Hash::make($request->password);

        $newUser =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPwd,
        ]);

        if(User::count() === 1) {
            // Grant first user all permissions
            UserPermission::create([
                'user_id' => $newUser->id,
                'permission_id' => Permission::where('code', 'GRANT_ALL')->first()->id,
            ]);
        }

        return $newUser;
    }
}
