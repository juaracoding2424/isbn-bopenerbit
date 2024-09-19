<?php

namespace App\Exports;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

class ReportIsbnExport implements FromArray
{
    protected $ku;
    public function __construct($data)
    {
        $this->ku = $data;
    }
    public function array(): array
    {
        return $this->ku;
    }
}