<?php

namespace Pi\Http\Requests\Clients\Users\Import;

use Pi\Clients\Users\UsersImporter;
use Pi\Http\Requests\Request;

class ImportProcessRequest extends Request
{
    public function rules()
    {
        return [];
    }

    public function getColumns()
    {
        return $this->get('column', []);
    }

    public function isRemoveFirstRow()
    {
        return $this->has('remove_first');
    }
}
