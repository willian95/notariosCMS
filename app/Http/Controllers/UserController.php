<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    function store(Request $request){

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
        $user->save();

        return response()->json(["msg" => "Usuario creado", "success" => true], 200);

    }

    function update(Request $request){

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != ""){
            $user->password = bcrypt($request->password);
        }
        $user->update();

        return response()->json(["msg" => "Usuario actualizado", "success" => true], 200);

    }

    function fetch(Request $request){

        $users = User::where("role_id", 2)->paginate(15);
        return response()->json($users);
    }

    function delete(Request $request){

        $user = User::find($request->id);
        $user->delete();

        return response()->json(["msg" => "Usuario eliminado", "success" => true], 200);

    }

    function edit($id){

        $user = User::find($id);
        return view("users.edit.index", ["user" => $user]);

    }

}
