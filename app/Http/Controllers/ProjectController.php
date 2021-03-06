<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSecondaryImage;
use App\Models\SecondaryContent;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        try {
            $slug = str_replace(' ', '-', $request->name);
            $slug = str_replace('/', '-', $slug);

            if (Project::where('slug', $slug)->count() > 0) {
                $slug = $slug.'-'.uniqid();
            }

            $project = new Project();
            $project->name = $request->name;
            $project->image = $request->image;
            $project->image_type = $request->mainImageFileType;
            $project->slug = $slug;
            $project->save();

            foreach (ProjectSecondaryImage::where('project_id', $project->id)->get() as $projectSecondaryImage) {
                $projectSecondaryImage->delete();
            }

            foreach ($request->workImages as $workImage) {
                $image = new ProjectSecondaryImage();
                $image->project_id = $project->id;
                $image->image = $workImage['finalName'];
                $image->type = $workImage['type'];
                $image->save();
            }

            return response()->json(['success' => true, 'msg' => 'Proyecto creado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'false' => 'Error en el servidor', 'err' => $e->getMessage(), 'ln' => $e->getLine()]);
        }
    }

    public function fetch(Request $request)
    {
        $projects = Project::paginate(15);

        return response()->json($projects);
    }

    public function fetchAll()
    {
        $projects = Project::all();

        return response()->json($projects);
    }

    public function update(Request $request)
    {
        try {
            $project = Project::find($request->id);
            $project->name = $request->name;
            if ($request->image) {
                $project->image = $request->image;
                $project->image_type = $request->mainImageFileType;
            }
            $project->update();

            foreach (ProjectSecondaryImage::where('project_id', $project->id)->get() as $projectSecondaryImage) {
                $projectSecondaryImage->delete();
            }

            foreach ($request->workImages as $workImage) {
                $image = new ProjectSecondaryImage();
                $image->project_id = $project->id;
                $image->image = $workImage['finalName'];
                $image->type = $workImage['type'];
                $image->save();
            }

            return response()->json(['success' => true, 'msg' => 'Proyecto actualizado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'false' => 'Error en el servidor', 'err' => $e->getMessage(), 'ln' => $e->getLine()]);
        }
    }

    public function delete(Request $request)
    {
        foreach (ProjectSecondaryImage::where('project_id', $request->id)->get() as $projectSecondaryImage) {
            $projectSecondaryImage->delete();
        }

        foreach (SecondaryContent::where('project_id', $request->id)->get() as $projectSecondaryImage) {
            $projectSecondaryImage->delete();
        }

        Project::where('id', $request->id)->delete();

        return response()->json(['success' => true, 'msg' => 'Proyecto eliminado']);
    }

    public function edit($id)
    {
        $project = Project::where('id', $id)->first();
        $projectSecondaryImages = ProjectSecondaryImage::where('project_id', $id)->get();

        return view('projects.edit.index', ['project' => $project, 'projectSecondaryImages' => $projectSecondaryImages]);
    }
}
