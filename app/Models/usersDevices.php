<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersDevices extends Model
{
    public $table='usersDevices';
    use HasFactory;
    protected $fillable = ['user_id','device_id'];
}
