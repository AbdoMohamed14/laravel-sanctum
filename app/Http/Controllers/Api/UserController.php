<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function register(RegisterUserRequest $request)
    {
        $birthday = $request->birthday;
        $years = Carbon::parse($birthday)->age;

        if($years < 18){
            return $this->sendError('your age must be greater than 18 year');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'is_admin' => 0,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $data = [
            'user' => $user,
            'token' => $user->createToken('MyApp')->plainTextToken,
        ];

        return $this->sendResponse($data, 'successfully registerd');

    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user){ 
            if(Hash::check($request->password, $user->password)){
                Auth::login($user);
                $data['token'] =  $user->createToken('MyApp')->plainTextToken; 
                $data['user'] =  $user;
       
                return $this->sendResponse($data, 'User login successfully.');
            }
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

}
