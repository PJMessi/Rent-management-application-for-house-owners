<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Renter;
use App\Room;

class RenterController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {   
        $rooms = Room::all();
        $renters = Renter::orderBy("created_at", "desc")->paginate(10);
        return response()->json([$renters, $rooms]);
    }

    public function store(Request $request)
    {
        $rules = [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'p_address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'date_of_join' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'is_child' => ['required', 'boolean']
        ];

        $customMessages = [
            'required' => 'This field is required',
            'date' => 'Enter a valid date'
        ];

        $this->validate($request, $rules, $customMessages);

        $renter = new Renter();
        $renter->f_name = ucwords($request["f_name"]);
        $renter->l_name = ucwords($request["l_name"]);
        $renter->phone_1 = $request["phone_1"];
        $renter->phone_2 = $request["phone_2"];
        $renter->p_address = ucwords($request["p_address"]);
        $renter->email = $request["email"];
        $renter->date_of_birth = $request["date_of_birth"];
        $renter->date_of_join = $request["date_of_join"];
        $renter->is_child = $request["is_child"];
        $renter->room_id = 0;
        
        if($request["photo"]) {
            $one = explode("/", $request["photo"]);
            $two = explode(":", $one[1]);
            $three = explode(";", $two[0]);
            $extn =  ".".$three[0];
            $image_name = time().$extn;
            \Image::make($request["photo"])->save(public_path('images/renters/') . $image_name);

            $renter->photo = $image_name;

        }

        $renter->save();
        return response()->json($renter);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $renter = Renter::findOrFail($id);
        $rules = [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'p_address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'date_of_join' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'is_child' => ['required', 'boolean']
        ];

        $customMessages = [
            'required' => 'This field is required',
            'date' => 'Enter a valid date'
        ];

        $this->validate($request, $rules, $customMessages);

        $renter->f_name = ucwords($request["f_name"]);
        $renter->l_name = ucwords($request["l_name"]);
        $renter->phone_1 = $request["phone_1"];
        $renter->phone_2 = $request["phone_2"];
        $renter->p_address = ucwords($request["p_address"]);
        $renter->email = $request["email"];
        $renter->date_of_birth = $request["date_of_birth"];
        $renter->date_of_join = $request["date_of_join"];
        $renter->is_child = $request["is_child"];
        $renter->room_id = 0;
        
        if($request["photo"] && strlen($request["photo"]) > 200) {
            if($user->photo) {                
                $old_img = public_path('images/renters/') . $user->photo;
                if(file_exists($old_img))
                    @unlink($old_img);
            }

            $one = explode("/", $request["photo"]);
            $two = explode(":", $one[1]);
            $three = explode(";", $two[0]);
            $extn =  ".".$three[0];
            $image_name = time().$extn;
            \Image::make($request["photo"])->save(public_path('images/renters/') . $image_name);

            $user->photo = $image_name;
        }

        $renter->save();
        error_log("works");
        return response()->json($renter);
    }

    public function destroy($id)
    {
        $renter = Renter::findOrFail($id);
        $renter->delete();
        return response()->json($renter);
    }
}
