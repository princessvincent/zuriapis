<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function Register(Request $request){
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|unique:users',
        'password' => 'required|min:6',
        'confirm_pass' => 'required|same:password'
    ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password  = Hash::make($request->password);

        $user->save();
        
        return response()->json([
            'status' => true,
            'user' => [
                'name' => $user->name,
                'email' =>  $user->email,
                'password' => $user->password
            ],
        ]);
    }
    public function Login(Request $request){
$request->validate([
    'email' => 'required|string',
    'password' => 'required|string'
]);

if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
{
    $user = $request->user();
    $tokenresult = $user->createToken('Personal Access Token');
    $token = $tokenresult->plainTextToken;
    $expires_at = Carbon::now()->addweeks(1);
    
    return response()->json(["success" => true, 'data' => [
        'user' => Auth::user(),
        'access_token' => $token,
        'token_type' => 'Bearer',
        'expires_at' => $expires_at
        ]]);
}else{
    return response()->json([
        "success" => false, 
        'msg'  => 'Unauthorize User',
        ]);
}

    }

    public function Update(Request $request, $id){
$user = User::find($id);
$input = $request->all();
$user->update($input);

return response()->json([
    'status' => true,
    'updated user' => [
'name' => $user->name,
'email' => $user->email,
    ],
]);

    }

    public function Delete($id){
$user = User::find($id);

$user->delete();
return response()->json([
    'status' => true,
    'user' => 'User Deleted!',
]);

    }

    public function Getuser($id){
$user = User::find($id);
return response()->json([
    'status' => true,
    'id' => $user->id,
    'name' => $user->name,
    'email' => $user->email,
]);

    }
    public function GetUsers(){
$user = User::all();

    return response()->json([
    'status' => true,
    'users' => $user,
]);
    }
}
