<?php

namespace Modules\CMS\Http\Requests;

use App\Http\Requests\RootRequest;


class BookUpdateRequest extends RootRequest
{
    public function authorize()
    {
        return has_permission('cms.book.edit');
    }

    public function rules()
    {
        return [
            'url' => 'required',
            'status' => 'required',
            'order' => 'required',
            'image' => 'nullable',
        ];
    }


    public function message(bool $absolute = true)
    {
        return [];
    }


}
