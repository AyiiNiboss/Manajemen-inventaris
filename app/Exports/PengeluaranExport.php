<?php

namespace App\Exports;

use App\Models\PengeluaranModel;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengeluaranExport implements FromCollection, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL', // Kolom dari relasi Barang
            'NAMA',
            'CATATAN',
            'BARANG'
        ];
    }

    public function collection()
    {
        $pembelian = PengeluaranModel::with(['detailPengeluaranRelasi.barangRelasi.satuanRelasi','userRelasi'])->where('status', 2)->get();

        return $pembelian->map(function ($item, $index) {
            $detailPembelian = '';
            
            foreach ($item->detailPengeluaranRelasi as $detail) {
                $detailPembelian .= $detail->barangRelasi->nama_barang . ",";
            }

            return [
                'NO' => $index + 1,
                'Tanggal' => $item->tgl,
                'Nama' => $item->userRelasi->name,
                'Catatan' => $item->catatan,
                'Barang' => $detailPembelian,
            ];
        });
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // Memberi gaya pada baris pertama (heading)
        $sheet->getStyle('A')->getFont()->setItalic(true); // Memberi gaya pada kolom 'Tanggal Masuk'

        // Memperbesar lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20); // Mengatur lebar kolom 'A'
        $sheet->getColumnDimension('B')->setWidth(30); // Mengatur lebar kolom 'B'
        $sheet->getColumnDimension('C')->setWidth(30); // Mengatur lebar kolom 'C'
        $sheet->getColumnDimension('D')->setWidth(30); // Mengatur lebar kolom 'D'
        $sheet->getColumnDimension('E')->setWidth(100); // Mengatur lebar kolom 'E'
        // Anda dapat menyesuaikan lebar kolom sesuai kebutuhan
    }
}