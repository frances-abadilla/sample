<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Requests\API\CreateUserRequest;

use App\Http\Resources\API\UserResource;

use App\Repositories\UserRepository;

class UserController extends BaseController
{
    protected $user = null;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try{
            return $this->sendResponse(UserResource::collection($this->user->getAllUsers()), 'Users retrieved.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try{
            $user = $this->user->createUser($request->validated());

            return $this->sendResponse(new UserResource($user), 'User created.', 201);
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            if((int) $id === $request->user()->id)
                return $this->sendError("You can't delete your own account.", [], 400);

            if(! $this->user->deleteUser($id))
                return $this->sendError('User not found.');

            return $this->sendResponse(null, 'User deleted.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }
}
