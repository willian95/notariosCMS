<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmsStoreRequest;
use App\Http\Requests\FilmsUpdateRequest;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{
    public function store(FilmsStoreRequest $request)
    {
        try {
            $film = new Film();
            $film->name = $request->name;
            $film->description = $request->description;
            $film->duration = $request->duration;
            $film->format = $request->format;
            $film->genre = $request->genre;
            $film->year = $request->year;
            $film->image = $request->image;
            $film->main_image_file_type = $request->mainImageFileType;
            $film->secondary_image = $request->secondaryImage;
            $film->secondary_image_file_type = $request->secondaryImageFileType;
            $film->save();

            return response()->json(['success' => true, 'message' => 'Film creado']);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['success' => false, 'message' => 'Ha ocurrido un error']);
        }
    }

    public function fetch()
    {
        $films = Film::orderBy('id', 'desc')->paginate(20);

        return response()->json($films);
    }

    public function update(FilmsUpdateRequest $request)
    {
        try {
            $film = Film::find($request->id);
            $film->name = $request->name;
            $film->description = $request->description;
            $film->duration = $request->duration;
            $film->format = $request->format;
            $film->genre = $request->genre;
            $film->year = $request->year;
            if (isset($request->image)) {
                $film->image = $request->image;
                $film->main_image_file_type = $request->mainImageFileType;
            }

            if (isset($request->secondaryImage)) {
                $film->secondary_image = $request->secondaryImage;
                $film->secondary_image_file_type = $request->secondaryImageFileType;
            }

            $film->update();

            return response()->json(['success' => true, 'message' => 'Film actualizado']);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['success' => false, 'message' => 'Ha ocurrido un error']);
        }
    }

    public function edit($id)
    {
        $film = Film::find($id);

        return view('films.edit.index', ['film' => $film]);
    }

    public function delete(Request $request)
    {
        try {
            $film = Film::find($request->id);
            $film->delete();

            return response()->json(['success' => true, 'message' => 'Film eliminado']);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['success' => false, 'message' => 'Ha ocurrido un error']);
        }
    }
}
