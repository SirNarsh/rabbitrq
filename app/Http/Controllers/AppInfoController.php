<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    public function index()
    {
        return [
            'name' => config('app.name'),
            'env' => config('app.env'),
            'debug' => config('app.debug'),
            'no_users' => User::count() === 0,
        ];
    }
}
