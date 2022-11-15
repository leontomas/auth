<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->role == 'masteradmin'){
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
            
            'id' => 'required|integer',
            'first_name' => 'string|max:50',
            'last_name' => 'string|max:50',
            'username' => 'max:50|unique:users,username,'.$this->id,

        ];
    }
}
