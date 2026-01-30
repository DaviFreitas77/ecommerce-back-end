<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;

class UpdateUserController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __construct(private UserService $userService) {
        $this->userService = $userService;
    }
    
    public function __invoke(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $user = $request->user()->id;
         return $this->userService->updateUser($data,$user);
    }
}