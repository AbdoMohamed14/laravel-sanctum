<?php

namespace App\Http\Controllers\Api;

use App\Models\device;
use App\Models\User;
use App\Models\usersDevices;
use Illuminate\Http\Request;

class DeviceController extends BaseController
{
    public function register_devices_by_user($user_id, array $devices_id)
    {
       foreach($devices_id as $id){
        usersDevices::create([
            'user_id' => $user_id,
            'device_id' => $id,

        ]);


       }

       
    }


    public function get_device_users($device_id)
    {
        $device = device::where('id', $device_id)->with('users')->first();

        return $device;
    }


    public function get_user_devices($user_id)
    {
        $user = User::where('id', $user_id)->with('devices')->first();

        return $user;
    }
}
