<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Requests\API\LoginRequest;

use App\Http\Resources\API\UserResource;

use App\Repositories\UserRepository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    protected $user = null;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        try{
            $user = $this->user->getUserByUsername($request->username);

            if(! $user || ! Hash::check($request->password, $user->password))
                return $this->sendError('Wrong username or password.', [], 401);

            if($user->role !== 'admin')
                return $this->sendError('Admin access only.', [], 403);

            $token = Str::random(60);
            $this->user->setToken($user, hash('sha256', $token));

            return $this->sendResponse([
                'token' => $token,
                'user'  => new UserResource($user),
            ], 'Signed in.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong. 1', ['error' => $e->getMessage()], 500);
        }
    }

    public function me(Request $request)
    {
        try{
            return $this->sendResponse(new UserResource($request->user()), 'Current user retrieved.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong. 2', ['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try{
            $this->user->setToken($request->user(), null);

            return $this->sendResponse(null, 'Signed out.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong. 3', ['error' => $e->getMessage()], 500);
        }
    }
}
