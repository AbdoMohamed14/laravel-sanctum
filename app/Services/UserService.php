<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
  
    public function check_user_age($birthday)
    {
        $years = Carbon::parse($birthday)->age;

        return $years < 18 ? false : true ;
    }

    public function create($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'is_admin' => 0,
            'password' => Hash::make($request->password),
        ]);

        $data = [
            'user' => $user,
            'token' => $user->createToken("api-token")->plainTextToken
        ];

        return $data;
    }


    public function login($request)
    {
        $user = User::where('email', $request['email'])->first();

        if($user){ 
            if(Hash::check($request['password'], $user->password)){
                $data =  $user;
                $data->token =  $user->createToken('MyApp')->plainTextToken; 
            }

            return $data;
        } 
        else{ 
         
            return false;
        } 

    }
}
