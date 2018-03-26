<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;

class UserStoreCrudRequest extends CrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'email'    => 'required|unique:'.config('laravel-permission.table_names.users', 'users').',email',
            'name'     => 'required',
            'mobile'     => 'required|unique:'.config('laravel-permission.table_names.users', 'users').',mobile',
            'password' => 'required|confirmed',
        ];
    }
}
