<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {   
        $this->authorize('isAdmin');
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($users);
    }

    public function store(Request $request)
    {        
        $rules = [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Renter'],
        ];

        $customMessages = [
            'required' => 'This field is required',
            'regex' => 'Enter a valid phone number',
            'date' => 'Enter a valid date'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = new User();
        $user->f_name = ucwords($request["f_name"]);
        $user->l_name = ucwords($request["l_name"]);
        $user->phone_1 = $request["phone_1"];
        $user->phone_2 = $request["phone_2"];
        $user->address = ucwords($request["address"]);
        $user->email = $request["email"];
        $user->date_of_birth = $request["date_of_birth"];
        $user->password = $request["password"];
        $user->role = $request["role"];

        if($request["photo"]) {
            $one = explode("/", $request["photo"]);
            $two = explode(":", $one[1]);
            $three = explode(";", $two[0]);
            $extn =  ".".$three[0];
            $image_name = time().$extn;
            \Image::make($request["photo"])->save(public_path('images/users/') . $image_name);

            $user->photo = $image_name;

        }

        $user->save();
        return response()->json($user);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        $rules = [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,'.$user->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Renter'],
        ];

        $customMessages = [
            'required' => 'This field is required',
            'regex' => 'Enter a valid phone number',
            'date' => 'Enter a valid date'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($id);
        $user->f_name = ucwords($request["f_name"]);
        $user->l_name = ucwords($request["l_name"]);
        $user->phone_1 = $request["phone_1"];
        $user->phone_2 = $request["phone_2"];
        $user->address = ucwords($request["address"]);

        $user->email = $request["email"];
        $user->date_of_birth = $request["date_of_birth"];

        if($request["password"])
            $user->password = $request["password"];
        $user->role = $request["role"];

        if($request["photo"] && strlen($request["photo"]) > 200) {
            if($user->photo) {                
                $old_img = public_path('images/users/') . $user->photo;
                if(file_exists($old_img))
                    @unlink($old_img);
            }

            $one = explode("/", $request["photo"]);
            $two = explode(":", $one[1]);
            $three = explode(";", $two[0]);
            $extn =  ".".$three[0];
            $image_name = time().$extn;
            \Image::make($request["photo"])->save(public_path('images/users/') . $image_name);

            $user->photo = $image_name;

        }

        $user->save();
        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::where('id', $id)->where('role','!=' ,'Admin')->get()->first();
        $user->delete();
        return response()->json($user);
    }

    public function profile() 
    {
        return auth('api')->user();
    }

    public function update_profile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,'.$user->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Renter'],
        ];

        $customMessages = [
            'required' => 'This field is required',
            'regex' => 'Enter a valid phone number',
            'date' => 'Enter a valid date'
        ];

        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($user->id);
        $user->f_name = ucwords($request["f_name"]);
        $user->l_name = ucwords($request["l_name"]);
        $user->phone_1 = $request["phone_1"];
        $user->phone_2 = $request["phone_2"];
        $user->address = ucwords($request["address"]);

        $user->email = $request["email"];
        $user->date_of_birth = $request["date_of_birth"];

        if($request["password"])
            $user->password = $request["password"];
        $user->role = $request["role"];

        if($request["photo"] && strlen($request["photo"]) > 200) {
            if($user->photo) {                
                $old_img = public_path('images/users/') . $user->photo;
                if(file_exists($old_img))
                    @unlink($old_img);
            }

            $one = explode("/", $request["photo"]);
            $two = explode(":", $one[1]);
            $three = explode(";", $two[0]);
            $extn =  ".".$three[0];
            $image_name = time().$extn;
            \Image::make($request["photo"])->save(public_path('images/users/') . $image_name);

            $user->photo = $image_name;

        }

        $user->save();
        return response()->json($user);
    }

    public function search() {
        if($search = \Request::get('q')) {
            $users = User::where( function($query) use ($search){
                $query->where('f_name', 'LIKE', "%$search%")
                ->orWhere('l_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('address', 'LIKE', "%$search%")            
                ->orWhere('phone_1', 'LIKE', "%$search%")
                ->orWhere('phone_2', 'LIKE', "%$search%")
                ->orWhere('role', 'LIKE', "%$search%")
                ;
            } )->paginate(10);
            return response()->json($users);
        }
        else {
            error_log("second");
            $users = User::orderBy('created_at', 'desc')->paginate(10);
            return response()->json($users);
        }
    }
}
