<?php

namespace Modules\Employee\Http\Requests;

use App\Http\Requests\RootRequest;

class AddressCreateRequest extends RootRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required',
            'employee_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country_id' => 'required|numeric',
        ];
    }


    public function message(bool $absolute = true)
    {
        return [
        ];
    }


}
