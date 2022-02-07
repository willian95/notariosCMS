<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Director;
use App\Models\DirectorContent;

class DirectorController extends Controller
{
    
    function store(Request $request){

        try{

            $slug = str_replace(" ","-", $request->name);
            $slug = str_replace("/", "-", $slug);

            if(Director::where("slug", $slug)->count() > 0){
                $slug = $slug."-".uniqid();
            }

            $director = new Director;
            $director->name = $request->name;
            $director->image = $request->image;
            $director->slug = $slug;
            $director->description = $request->description;
            $director->vimeo_link = $request->vimeo_link;
            $director->save();

            foreach(DirectorContent::where("director_id", $director->id)->get() as $directorContent){
                $directorContent->delete();
            }

            foreach($request->workImages as $workImage){

                $image = new DirectorContent;
                $image->director_id = $director->id;
                $image->image = $workImage['finalName'];
                $image->type = $workImage['type'];
                $image->save();

            }

            return response()->json(["success" => true, "msg" => "Director creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

    function fetch(Request $request){

        $directors = Director::paginate(15);
        return response()->json($directors);

    }

    function update(Request $request){

        try{

            $director = Director::find($request->id);
            $director->name = $request->name;
            if($request->image != ""){
                $director->image = $request->image;
            }
            $director->description = $request->description;
            $director->vimeo_link = $request->vimeo_link;
            $director->update();

            foreach(DirectorContent::where("director_id", $director->id)->get() as $directorContent){
                $directorContent->delete();
            }

            foreach($request->workImages as $workImage){

                $image = new DirectorContent;
                $image->director_id = $director->id;
                $image->image = $workImage['finalName'];
                $image->type = $workImage['type'];
                $image->save();

            }

            return response()->json(["success" => true, "msg" => "Director actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "false" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }
    }

    function delete(Request $request){

        foreach(DirectorContent::where("director_id", $request->id)->get() as $projectSecondaryImage){
            $projectSecondaryImage->delete();
        }

        Director::where("id", $request->id)->delete();

        return response()->json(["success" => true, "msg" => "Director eliminado"]);

    }

    function edit($id){

        $project = Director::where("id", $id)->first();
        $projectSecondaryImages = DirectorContent::where("director_id", $id)->get();

        return view("directors.edit.index", ["director" => $project, "directorContent" => $projectSecondaryImages]);

    }

}
