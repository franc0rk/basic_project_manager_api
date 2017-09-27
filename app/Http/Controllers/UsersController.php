<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('json_request');
        $this->middleware('auth');
    }

    //Return a token when  a user has logged in
    public function token(Request $request)
    {
        try {
            $data = $request->json()->all();

            $user = User::where('username', $data['username'])->first();

            if($user && Hash::check($data['password'], $user->password)) {
                return response()->json($user, 200);
            } else {
                response()->json(['error' => 'No content'], 406);
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => 'No content'], 406);
        }
    }

    public function index(Request $request)
    {
        $users = User::all();
        return response()->json($users,200);
    }

    public function show(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules(false));
        $data = $request->json()->all();
        $user = User::create($data);
        return response()->json($user,201);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $this->validate($request, $this->validationRules(true, $id));
            $data = $request->json()->all();
            $user->fill($data);
            $user->save();
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    protected function validationRules($update, $id = 0)
    {
        ($update) ? $username_rule = 'required|alpha_num|min:4|unique:users,username,'. $id : $username_rule = 'required|alpha_num|min:4|unique:users';
        ($update) ? $email_rule = 'required|email|unique:users,email,'. $id : $email_rule = 'required|email|unique:users';
        ($update) ? $password_rule = 'confirmed|min:6' : $password_rule = 'required|confirmed|min:6';
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'username'   => $username_rule,
            'email'      => $email_rule,
            'password'   => $password_rule,
        ];
    }
}
