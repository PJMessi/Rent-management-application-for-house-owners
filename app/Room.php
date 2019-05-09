<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function renters() {
        return $this->hasMany('App\Renter', 'room_id');
    }
}
