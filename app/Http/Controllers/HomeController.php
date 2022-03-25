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

    public function edit($id)
    {
        $homeProject = HomeProject::find($id);

        return view('homeProjects.edit.index', ['data' => $homeProject]);
    }

    public function update(Request $request)
    {
        $homeProject = HomeProject::find($request->id);
        $homeProject->title = $request->title;
        $homeProject->director = $request->director;
        if (isset($request->image)) {
            $homeProject->video = $request->image;
        }

        if (isset($request->comercial)) {
            $homeProject->video_comercial = $request->comercial;
        }

        $homeProject->order = $request->order;
        $homeProject->update();

        return response()->json(['message' => 'Orden actualizado', 'success' => true]);
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
