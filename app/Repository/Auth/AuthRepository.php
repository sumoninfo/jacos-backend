<?php

namespace App\Repository\Auth;

use Illuminate\Http\Request;

interface AuthRepository
{
    public function login(Request $request);

    public function register(Request $request);

    public function logout(Request $request);
}
