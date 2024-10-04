<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportIsbnExport implements FromArray, WithHeadings
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

    public function headings(): array
    {
        return [
            'No',
            'ISBN',
            'Judul',
            'Jenis Terbitan',
            'Sumber Data',
            'Kepengarangan',
            'Bulan/Tahun Terbit',
            'Tanggal Permohonan',
            'Tanggal Disetujui',
            'Penyerahan Perpusnas',
            'Penyerahan Provinsi'
        ];
    }
}