<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends BaseController
{
    public function register(Request $request)
    {
        $birthday = $request->birthday;



        $years = Carbon::parse($birthday)->age;

        if($years < 18){
            return $this->sendError('your age must be greater than 18 year');
        }

        $validate =  Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($validate->fails()){
            return $this->sendError('errors', $validate->errors());
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
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $data['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $data['user'] =  $user;
   
            return $this->sendResponse($data, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
