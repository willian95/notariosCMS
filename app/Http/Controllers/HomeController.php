<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeProject;

class HomeController extends Controller
{


    function store(Request $request){

        $homeProject = new HomeProject;
        $homeProject->title = $request->title;
        $homeProject->director = $request->director;
        $homeProject->video = $request->image;
        $homeProject->order = $request->order;
        $homeProject->save();

        return response()->json(["message" => "Orden agregado", "success" => true]);

    }


    function delete(Request $request){

        $homeLanding = HomeProject::where("id", $request->id)->first();
        $homeLanding->delete();

        return response()->json(["message" => "Orden eliminado", "success" => true]);

    }

    function fetch(){
        $projects = HomeProject::all();
        return response()->json($projects);
    }

}
