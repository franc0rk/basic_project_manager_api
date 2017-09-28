<?php

namespace App\Http\Controllers;

use App\ProjectStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectStatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('json_request');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $project_statuses = ProjectStatus::all();
        return response()->json($project_statuses,200);
    }

    public function show(Request $request, $id)
    {
        try {
            $project_status = ProjectStatus::findOrFail($id);
            return response()->json($project_status, 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());
        $data = $request->json()->all();
        $project_status = ProjectStatus::create($data);
        return response()->json($project_status,201);
    }

    public function update(Request $request, $id)
    {
        try {
            $project_status = ProjectStatus::findOrFail($id);
            $this->validate($request, $this->validationRules());
            $data = $request->json()->all();
            $project_status->fill($data);
            $project_status->save();
            return response()->json($project_status, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $project_status = ProjectStatus::findOrFail($id);
            $project_status->delete();
            return response()->json($project_status, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    protected function validationRules()
    {
        return [
            'name' => 'required',
        ];
    }
}
