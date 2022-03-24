<?php

namespace App\Http\Controllers;

use App\Models\HomeProject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function store(Request $request)
    {
        $homeProject = new HomeProject();
        $homeProject->title = $request->title;
        $homeProject->director = $request->director;
        $homeProject->video = $request->image;
        $homeProject->video_comercial = $request->comercial;
        $homeProject->order = $request->order;
        $homeProject->save();

        return response()->json(['message' => 'Orden agregado', 'success' => true]);
    }

    public function delete(Request $request)
    {
        $homeLanding = HomeProject::where('id', $request->id)->first();
        $homeLanding->delete();

        return response()->json(['message' => 'Orden eliminado', 'success' => true]);
    }

    public function fetch()
    {
        $projects = HomeProject::all();

        return response()->json($projects);
    }
}
