<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->role == 'masteradmin' || 
        auth()->user()->role == 'admin'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'amount' => 'between:-1, 9999999.9999',
            'type' => 'required|string|in:income,expense',
            'note' => 'required|string|max:50',

        ];
    }
}
