<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Support\Carbon;
use App\Http\Requests\Wallet\CreateRequest;
use App\Http\Requests\Wallet\ReadRequest;
use App\Http\Requests\Wallet\ListRequest;
use App\Http\Requests\Wallet\UpdateRequest;
use App\Http\Requests\Wallet\DeleteRequest;
use Illuminate\Support\Facades\Auth;

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
        $search_columns  = ['name', 'address'];
        $limit = ($request->limit) ?  $request->limit : 50;
        $sort_column = ( $request->sort_column) ?  $request->sort_column : 'id';
        $sort_order = ( $request->sort_order) ?  $request->sort_order : 'desc';
        $status = 0;
        $data = new Wallet();
        /* Searching for the value of the request. */
        if(isset($request->search)) {
            $key = $request->search;
            /* Searching for the key in the columns. */
            $data = $data->where(function ($q) use ($search_columns, $key) {
                foreach ($search_columns as $column) {
                    /* Searching for the key in the column. */
                    $q->orWhere($column, 'LIKE', '%'.$key.'%');
                }
            });
        }
        /* Filtering the data by date. */
        if($request->from && $request->to){
            $data = $data->whereBetween('created_at', [
                Carbon::parse($request->from)->format('Y-m-d H:i:s'),
                Carbon::parse($request->to)->format('Y-m-d H:i:s')
                ]);
        }
        $data = $data->orderBy($sort_column, $sort_order)->paginate($limit);
        if($data){
            $status = 1;
            return response()->json([
                    'data' => $data,
                    'status' => $status
                ]);
        } else {
            return response()->json([
                'data' => $data,
                'status' => $status
            ]);
        }
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
