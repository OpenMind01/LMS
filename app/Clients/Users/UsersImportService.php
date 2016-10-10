<?php

namespace Pi\Clients\Users;

use Pi\Clients\Client;
use Pi\Exceptions\Clients\Users\Import\InvalidCsvException;
use Pi\Http\Requests\Clients\Users\Import\ImportCreateRequest;

class UsersImportService
{
    public function getPossibleDelimiters()
    {
        return [
            'Comma' => 'Comma(,)',
            'Tab' => 'Tab(   )',
            'Semicolon' => 'Semicolon(;)',
            'Colon' => 'Colon(:)',
        ];
    }

    /**
     * @param $id
     * @return UsersImport
     */
    public function get($id)
    {
        return UsersImport::findOrFail($id);
    }

    /**
     * @param Client $client
     * @param ImportCreateRequest $request
     * @return UsersImport
     */
    public function create(Client $client, ImportCreateRequest $request)
    {
        $import = new UsersImport();
        $import->client_id = $client->id;
        $import->delimiter = $request->getDelimiter();
        $import->csv = $request->getCsvContents();

        $import->save();

        return $import;
    }

    /**
     * @param UsersImport $import
     * @throws \Exception
     */
    public function delete(UsersImport $import)
    {
        $import->delete();
    }

    /**
     * @param UsersImport $import
     * @return array
     */
    public function getCsvData(UsersImport $import)
    {
        $rows = explode("\n", $import->csv);
        $rows = array_map('trim', $rows);

        $data = [];
        foreach($rows as $row)
        {
            if(trim($row) != '')
            $data[] = str_getcsv($row, $this->getDelimiter($import->delimiter));
        }

        return $data;
    }

    public function getColumnsData(UsersImport $import)
    {
        $data = $this->getCsvData($import);

        if(count($data) == 0)
        {
            throw new InvalidCsvException();
        }

        if(count($data[0]) == 0)
        {
            throw new InvalidCsvException();
        }

        $columns = [];
        foreach($data[0] as $value)
        {
            $columns[] = [
                'sample' => []
            ];
        }

        foreach($columns as $key => &$column)
        {
            for($i = 0; $i < 5; $i++)
            {
                if(!isset($data[$i])) continue;

                if(!isset($data[$i][$key])) continue;

                $column['sample'][] = $data[$i][$key];
            }
        }

        return $columns;
    }

    private function getDelimiter($delimiterName)
    {
        $delimiters = [
            'Comma' => ',',
            'Tab' => "\t",
            'Semicolon' => ';',
            'Colon' => ':',
        ];

        return $delimiters[$delimiterName];
    }
}