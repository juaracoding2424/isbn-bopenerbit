<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;

class ReportIsbnExport implements FromArray
{
    protected $data;
    protected $namaPenerbit;

    public function __construct($data, $namaPenerbit)
    {
        $this->data = $data;
        $this->namaPenerbit = $namaPenerbit;
    }
    public function array(): array
    {
        return $this->data;
    }
}