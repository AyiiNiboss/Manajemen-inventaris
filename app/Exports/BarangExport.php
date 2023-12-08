<?php

namespace App\Exports;

use App\Models\StokModel;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'Tanggal Masuk',
            'Nama Barang', // Kolom dari relasi Barang
            'Sisa Stok'
        ];
    }

    public function collection()
    {
        return StokModel::with('BarangRelasi')->get()
        ->map(function ($item) {
            return [
                'Tanggal Masuk' => $item->tgl_masuk,
                'Nama Barang' => $item->BarangRelasi->nama_barang, // Memanggil kolom 'nama_barang' dari relasi Barang
                'Sisa Stok' => $item->sisa_stok
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true); // Memberi gaya pada baris pertama (heading)
        $sheet->getStyle('A')->getFont()->setItalic(true); // Memberi gaya pada kolom 'Tanggal Masuk'

        // Memperbesar lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20); // Mengatur lebar kolom 'A'
        $sheet->getColumnDimension('B')->setWidth(30); // Mengatur lebar kolom 'B'
        // Anda dapat menyesuaikan lebar kolom sesuai kebutuhan
    }
}
