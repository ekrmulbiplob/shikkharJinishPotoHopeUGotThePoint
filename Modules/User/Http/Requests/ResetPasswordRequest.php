<?php

namespace Modules\User\Http\Requests;

use App\Http\Requests\RootRequest;

class ResetPasswordRequest extends RootRequest{

    public function authorize()
    {
        return is_company_group() || is_company_group() || is_branch_group();
    }


    public function rules()
    {
        return [
            'user_id' => 'required',
            'password' => 'required|string|min:5|max:16|confirmed',
        ];
    }


    public function messages()
    {
        return [
           /* 'name.required' => 'A title is required',
            'role.required' => 'A message is required',*/
        ];
    }

}
