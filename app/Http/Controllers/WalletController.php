<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Wallet\CreateRequest;
use App\Http\Requests\Wallet\ReadRequest;
use App\Http\Requests\Wallet\ListRequest;
use App\Http\Requests\Wallet\UpdateRequest;
use App\Http\Requests\Wallet\DeleteRequest;

class WalletController extends Controller
{
    public function create(CreateRequest $request)
    {
        $validated = $request->safe()->all();

        $status = 0;

        // $validated['user_id'] = auth()->user()->id;
        $validated['user_id'] = Auth::user()->id;

        $data = Wallet::create($validated);

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

        $data = Wallet::find($validated['id']);

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status,
        ]);
        
    }

    public function list(ListRequest $request){
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

        $status = 0;

        $data = Wallet::find($validated['id']);

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

        $data = Wallet::whereId($validated)->delete();
        
        if($data) $status = 1;
        
        return response()->json([
            "message" => "User deleted",
            "status" => $status
        ]);
    }
}
