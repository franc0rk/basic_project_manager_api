<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('json_request');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $projects = Project::all();
        return response()->json($projects,200);
    }

    public function show(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json($project, 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());
        $data = $request->json()->all();
        $project = Project::create($data);
        return response()->json($project,201);
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            $this->validate($request, $this->validationRules());
            $data = $request->json()->all();
            $project->fill($data);
            $project->save();
            return response()->json($project, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json($project, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    protected function validationRules()
    {
        return [
            'name'              => 'required',
            'description'       => 'required',
            'client_id'         => 'required',
            'project_status_id' => 'required',
        ];
    }
}
