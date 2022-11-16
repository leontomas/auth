<?php

namespace App\Http\Controllers;

/* Importing the Company model. */
use App\Models\Company;
/* Importing the DB and Auth classes. */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
/* Importing the request classes that are used to validate the data that is sent to the controller. */
use App\Http\Requests\Company\CreateRequest;
use App\Http\Requests\Company\ReadRequest;
use App\Http\Requests\Company\ListRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Http\Requests\Company\DeleteRequest;

class CompanyController extends Controller
{
    public function create(CreateRequest $request)
    {
        $validated = $request->safe()->all();

        $status = 0;

        $validated['user_id'] = Auth::user()->id;

        $data = Company::create($validated);

        if($data) $status = 1;

        return response()->json([
            "status" => $status,
            "data" => $data
        ]);
    }

    public function read(ReadRequest $request)
    {
        $validated = $request->safe()->only(['id']);

        $status = 0;

        $data = Company::find($validated['id']);

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status,
        ]);
    }
    public function list(ListRequest $request)
    {
        $validated = $request->safe()->only('user_id');

        $validated['user_id'] = auth()->user()->id;
        
        $status = 0;

        $data = DB::table('companies')
        ->select('*')
        ->where('user_id', $validated['user_id'])
        ->get();
        
        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status
        ]);

    }

    public function update(UpdateRequest $request)
    {
        $validated = $request->safe()->all();

        $validated['user_id'] = auth()->user()->id;

        $status = 0;

        $data = Company::find($validated['id']);

        $data->update($validated);

        if($data) $status = 1;

            return response()->json([
                "data" =>  $data,
                "status" => $status
        ]);
    }

    public function delete(DeleteRequest $request)
    {
        $validated = $request->safe()->only(['id']);
        
        $status = 0;

        $data = Company::whereId($validated)->delete();
        
        if($data) $status = 1;
        
        return response()->json([
            "message" => "User deleted",
            "status" => $status
        ]);

    }
    
}