<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;

    protected $fillable = ['device_number'];




    public function users()
    {
        return $this->hasMany(usersDevices::class);
    }
}
