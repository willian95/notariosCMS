<?php

namespace App\Http\Controllers;

use App\Models\Photographer;
use App\Models\PhotographerPicture;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $photographer = new Photographer();
            $photographer->type = $request->type;
            $photographer->name = $request->name;
            $photographer->save();

            foreach (PhotographerPicture::where('photographer_id', $photographer->id)->get() as $photographerContent) {
                $photographerContent->delete();
            }

            foreach ($request->workImages as $workImage) {
                $image = new PhotographerPicture();
                $image->photographer_id = $photographer->id;
                $image->image = $workImage['finalName'];
                $image->save();
            }

            return response()->json(['success' => true, 'msg' => 'Fotografo creado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'false' => 'Error en el servidor', 'err' => $e->getMessage(), 'ln' => $e->getLine()]);
        }
    }

    public function fetch(Request $request)
    {
        $directors = Photographer::paginate(15);

        return response()->json($directors);
    }

    public function update(Request $request)
    {
        try {
            $photographer = Photographer::find($request->id);
            $photographer->type = $request->type;
            $photographer->name = $request->name;
            $photographer->update();

            foreach (PhotographerPicture::where('photographer_id', $photographer->id)->get() as $photographerContent) {
                $photographerContent->delete();
            }

            foreach ($request->workImages as $workImage) {
                $image = new PhotographerPicture();
                $image->photographer_id = $photographer->id;
                $image->image = $workImage['finalName'];
                $image->save();
            }

            return response()->json(['success' => true, 'msg' => 'Fotografo actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'false' => 'Error en el servidor', 'err' => $e->getMessage(), 'ln' => $e->getLine()]);
        }
    }

    public function delete(Request $request)
    {
        foreach (PhotographerPicture::where('photographer_id', $request->id)->get() as $projectSecondaryImage) {
            $projectSecondaryImage->delete();
        }

        Photographer::where('id', $request->id)->delete();

        return response()->json(['success' => true, 'msg' => 'Fotografo eliminado']);
    }

    public function edit($id)
    {
        $project = Photographer::where('id', $id)->first();
        $projectSecondaryImages = PhotographerPicture::where('photographer_id', $id)->get();

        return view('services.edit.index', ['director' => $project, 'directorContent' => $projectSecondaryImages]);
    }
}
