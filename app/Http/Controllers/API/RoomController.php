<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Room;

class RoomController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $rooms = Room::orderBy("created_at", "desc")->paginate(10);
        return response()->json($rooms);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'rent_amount' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
        ];

        $customMessages = [
            'required' => 'This field is required',
        ];

        $this->validate($request, $rules, $customMessages);

        $room = new Room();
        $room->name = ucwords($request["name"]);
        $room->rent_amount = $request["rent_amount"];
        $room->description = $request["description"];
        $room->save();

        return response()->json($room);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $rules = [
            'name' => ['required', 'string', 'max:191'],
            'rent_amount' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
        ];

        $customMessages = [
            'required' => 'This field is required',
        ];

        $this->validate($request, $rules, $customMessages);
        $room->name = $request["name"];
        $room->rent_amount = $request["rent_amount"];
        $room->description = $request["description"];
        $room->save();
        return response()->json($room);
    }


    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json($room);
    }
}
