<?php

namespace Pi\Http\Requests\Clients\Users\Import;

use Pi\Clients\Users\UsersImportService;
use Pi\Http\Requests\Request;

class ImportCreateRequest extends Request
{
    public function rules()
    {
        return [
            'csv' => 'required',
            'delimiter' => 'required|in:' . join(',', array_keys(app(UsersImportService::class)->getPossibleDelimiters())),
        ];
    }

    public function getCsvContents()
    {
        return file_get_contents($this->file('csv')->getRealPath());
    }

    public function getDelimiter()
    {
        return $this->get('delimiter');
    }
}
