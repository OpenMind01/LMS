<?php

namespace Pi\Http\Requests\Industries;

class IndustryUpdateRequest extends IndustryCreateRequest
{
    public function rules()
    {
        return [
            'title' => 'required|unique:industries,title,' . \Route::current()->parameter('industries')
        ];
    }
}