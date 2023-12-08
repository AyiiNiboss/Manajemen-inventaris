<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use Carbon\Carbon;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\Datatables;

class StokController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $query = StokModel::with('barangRelasi');
            // Handle search
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $searchValue = $request->input('search')['value'];
                $query->whereHas('barangRelasi', function($query) use ($searchValue) {
                    $query->where('nama_barang', 'like', '%' . $searchValue . '%');
                })
                ->orWhere('tgl_masuk', 'like', '%' . $searchValue . '%')
                ->orWhere('sisa_stok', 'like', '%' . $searchValue . '%');
            }
    
            // Continue building the query and processing DataTables
            $data = $query->select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl_masuk_formatted', function ($row) {
                    return Carbon::parse($row->tgl_masuk)->translatedFormat('d F Y');
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
 
        return view('stok.stok');
    }

    public function LaporanStok(){
        $stok = StokModel::with('barangRelasi')->get();
        return view('Laporan.barang.stok-barang', [
            'data' => $stok
        ]);
    }

    public function FilterStokBarang(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Lakukan pengambilan data dengan filter berdasarkan tanggal
        $filteredData = StokModel::with('barangRelasi')->whereBetween('tgl_masuk', [$start_date, $end_date])->get();

        // Kemudian kembalikan data yang telah difilter sebagai respons
        return view('Laporan.barang.stok-barang', [
            'data' => $filteredData,
            'start_date' =>$start_date,
            'end_date' => $end_date
        ]);
    }

    public function ExportAllPDFFilter($start_date, $end_date){
        $pembelian = StokModel::with('barangRelasi')
        ->whereBetween('tgl_masuk', [$start_date, $end_date])
        ->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('laporan.barang.stok-export-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

    public function ExportAllPDF(){
        $pembelian = StokModel::with('barangRelasi')->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('Laporan.barang.stok-export-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

    public function ExportExcel(){
        return Excel::download(new BarangExport(), 'Stok_Barang.xlsx');
    }
}
