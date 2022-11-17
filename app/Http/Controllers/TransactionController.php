<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Transaction\CreateRequest;
use App\Http\Requests\Transaction\ReadRequest;
use App\Http\Requests\Transaction\ListRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Requests\Transaction\DeleteRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function create(CreateRequest $request)
    {
        $validated = $request->safe()->all();

        $status = 0;

        $validated['user_id'] = Auth::user()->id;

        $data = Transaction::create($validated);

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

        $data = Transaction::find($validated['id']);

        if($data) $status = 1;

        return response()->json([
            'data' => $data,
            'status' => $status,
        ]);
    }
    public function list(ListRequest $request)
    {
        $search_columns  = ['name', 'address'];
        $limit = ($request->limit) ?  $request->limit : 50;
        $sort_column = ( $request->sort_column) ?  $request->sort_column : 'id';
        $sort_order = ( $request->sort_order) ?  $request->sort_order : 'desc';
        $status = 0;
        $data = new Transaction();
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

        $validated['user_id'] = auth()->user()->id;

        $status = 0;

        $data = Transaction::find($validated['id']);

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

        $data = Transaction::whereId($validated)->delete();
        
        if($data) $status = 1;
        
        return response()->json([
            "message" => "User deleted",
            "status" => $status
        ]);

    }
}
