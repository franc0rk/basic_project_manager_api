<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('json_request');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clients = Client::all();
        return response()->json($clients,200);
    }

    public function show(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client, 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules(false));
        $data = $request->json()->all();
        $client = Client::create($data);
        return response()->json($client,201);
    }

    public function update(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $this->validate($request, $this->validationRules(true, $id));
            $data = $request->json()->all();
            $client->fill($data);
            $client->save();
            return response()->json($client, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            return response()->json($client, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 406);
        }
    }

    protected function validationRules($update, $id = 0)
    {
        ($update) ? $email_rule = 'required|email|unique:clients,email,'. $id : $email_rule = 'required|email|unique:clients';
        return [
            'email'      => $email_rule,
        ];
    }
}
