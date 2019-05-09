<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Room;
use App\Renter;
use App\User;

class DashboardController extends Controller
{
    public function dashboard() {
        $users_count = User::count();
        $rentees_count = Renter::count();
        $rooms_count = Room::count();

        return response()->json([
            'users_count' => $users_count,
            'rentees_count' => $rentees_count,
            'rooms_count'=> $rooms_count
        ]);
    }
}
