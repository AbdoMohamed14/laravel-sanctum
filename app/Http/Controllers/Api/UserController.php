<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {        
        $check_age = $this->userService->check_user_age($request->birthday);

        if(! $check_age){return $this->sendError('you age is must be over than 18 years');}

        $registerd_user = $this->userService->create($request);

        return $this->sendResponse($registerd_user, 'successfully registerd');

    }


    public function login(Request $request)
    {
        $data = $this->userService->login($request->only('email', 'password'));

        if(! $data){
            return $this->sendError("wrong information please try again");
        } 

        return $data;
    }

}
