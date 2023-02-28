<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(LoginRequest $request){
        $user = User::create($request->validated());

        return response([
            "id" => Hashids::encode($user->id),
            "name" => $user->name
        ], 201);
    }
}
