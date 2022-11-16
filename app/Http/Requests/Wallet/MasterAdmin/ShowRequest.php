<?php

namespace App\Http\Requests\Wallet\MasterAdmin;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->role === 'masteradmin'){
            return true;
        }else{
            return 'you do not have access!';
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
            'id' => 'required|integer|exists:wallets,id'
        ];
    }
}
