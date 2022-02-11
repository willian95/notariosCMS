<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecondaryContent;
use App\Models\Project;
use App\Models\Client;

class UserController extends Controller
{

    function sendEmail($name, $email, $client_id){


        $data = [
            "name" => $name,
            "email" =>$email,
            "client_id" => $client_id
        ];
        
        \Mail::send("emails.client", $data, function($message) use ($name, $email) {

            $message->to($name, $email)->subject("Has sido invitado para ingresar a un contenido");
            $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));

        });

    }

    function storeSecondaryContent($request, $client_id){

        foreach($request->secondaryContent as $content){

            $project = Project::where("id", $content["project_id"])->first();
            $token = bcrypt(uniqid());

            $contentModel = new SecondaryContent;
            $contentModel->project_id = $content["project_id"];
            $contentModel->url = env("URL_FRONT")."proyecto/".$project->slug."?token=".$token;
            $contentModel->token = $token;
            $contentModel->client_id = $client_id;
            $contentModel->save();

        }


    }

    
    function store(Request $request){

        $client = new Client;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->save();

        $this->storeSecondaryContent($request, $client->id);

        $data = [
            "name" => $request->name,
            "email" =>$request->email,
            "client_id" => $client->id
        ];

        $name = $request->name;
        $email = $request->email;

        \Mail::send("emails.client", $data, function($message) use ($name, $email) {

            $message->to($email)->subject("Has sido invitado para ingresar a un contenido");
            $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));

        });

        return response()->json(["msg" => "Usuario creado", "success" => true], 200);

    }

    function update(Request $request){

        $client = Client::find($request->id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->update();

        foreach(SecondaryContent::where("client_id", $client->id)->get() as $content){
            $content->delete();
        }

        $this->storeSecondaryContent($request, $client->id);

        $this->sendEmail($request->name, $request->email, $client->id);

        return response()->json(["msg" => "Usuario actualizado", "success" => true], 200);

    }

    function fetch(Request $request){

        $users = Client::paginate(15);
        return response()->json($users);
    }

    function delete(Request $request){

        $user = Client::find($request->id);
        foreach(SecondaryContent::where("client_id", $request->id)->get() as $content){
            $content->delete();
        }
        $user->delete();

        return response()->json(["msg" => "Usuario eliminado", "success" => true], 200);

    }

    function edit($id){

        $secondaryContents = SecondaryContent::where("client_id", $id)->get();
        $user = Client::find($id);
        return view("users.edit.index", ["user" => $user, "secondaryContents" => $secondaryContents]);

    }

}
