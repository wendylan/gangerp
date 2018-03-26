<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Auth;

class UserUpdateCrudRequest extends CrudRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        return [
            'mobile'     => 'required|unique:users,id,'.$this->get('id'),
            'name'     => 'required',
            'password' => 'confirmed',
        ];
    }
}
