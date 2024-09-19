<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportIsbnExport implements FromArray, WithTitle
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

    public function title(): string
    {
        return 'Laporan Data ISBN ' . $this->namaPenerbit;
    }
}