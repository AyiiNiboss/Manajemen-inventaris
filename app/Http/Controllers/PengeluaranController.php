<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;
use App\Models\PengeluaranModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPengeluaranModel;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
    public function index(){
        if(Auth::user()->role_id == 1){
            $pengeluaran = PengeluaranModel::with('userRelasi')->where('status', 2)->get();
        }elseif(Auth::user()->role_id == 2){
            $pengeluaran = PengeluaranModel::with('userRelasi')->where('user_id', Auth::user()->id)->get();
        }
        return view('pengeluaran.pengeluaran', [
            'data' => $pengeluaran
        ]);
    }

    public function create(){
        return view('pengeluaran.pengeluaran-add');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'tgl' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
        ], [
            'tgl.required' => 'Tanggal masuk barang harus diisi.',
            'barang_id.*.required' => 'Nama barang harus diisi.',
            'jumlah.*.required' => 'Jumlah barang harus diisi.',
        ]);

        $success = true; // Initialize the success flag
        $exceededStock = []; // Initialize an array to store exceeded stock items
    
        // Start a database transaction
        DB::beginTransaction();
    
        // Simpan data pengeluaran
        $pengeluaran = new PengeluaranModel();
        $pengeluaran->tgl = $validatedData['tgl'];
        $pengeluaran->catatan = $request->input('catatan');
        $pengeluaran->user_id = Auth::user()->id;
        $pengeluaran->save();
    
        // Simpan detail pembelian
        foreach ($validatedData['barang_id'] as $key => $barangId) {
            $detailPengeluaran = new DetailPengeluaranModel();
            $detailPengeluaran->barangkeluar_id = $pengeluaran->id;
            $detailPengeluaran->barang_id = $barangId;
            $detailPengeluaran->jumlah = $validatedData['jumlah'][$key];
            // tambahkan data lainnya sesuai kebutuhan
            $detailPengeluaran->save();
    
            $existingStock = StokModel::where('barang_id', $barangId)->first();
            if ($existingStock) {
                // Check if stock is sufficient
                if ($existingStock->sisa_stok >= $validatedData['jumlah'][$key]) {
                    $existingStock->sisa_stok -= $validatedData['jumlah'][$key];
                    $existingStock->save();
                } else {
                    $success = false; // Mark as unsuccessful if stock is insufficient
                    $exceededStock[] = $barangId; // Add the exceeded stock item to the array
                }
            } else {
                $success = false;
            }
        }
    
        if ($success) {
            // If all operations were successful, commit the transaction
            DB::commit();
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil ditambah !!');
        } else {
            // If any operation failed, rollback the transaction
            DB::rollBack();
            $exceededStockNames = implode(', ', $exceededStock);
            Session::flash('status', 'error');
            Session::flash('pesan', "Data Gagal ditambah. Barang $exceededStockNames melebihi stok yang ada.");
        }
    
        return redirect('/barang-keluar');
    }

    public function getData($id){
        $stockObat = StokModel::with('barangRelasi.satuanRelasi')->where('barang_id', $id)->get();
        return response()->json($stockObat);
    }

    public function view($id){
        $pengeluaran = DetailPengeluaranModel::with(['barangRelasi.satuanRelasi', 'pengeluaranRelasi'])->where('barangkeluar_id', $id)->get();
        $tgl_pengeluaran = PengeluaranModel::with('userRelasi')->FindOrFail($id);
        return view('pengeluaran.pengeluaran-view', [
            'data_pengeluaran' => $tgl_pengeluaran,
            'data' => $pengeluaran,
        ]);
    }

    public function AccTampil(){
        $pengeluaran = PengeluaranModel::with('userRelasi')->where('status', 1)->get();
        return view('pengeluaran.pengeluaran-acc', [
            'data' => $pengeluaran
        ]);
    }

    public function ACC(Request $request, $id){
        $pengeluaran = PengeluaranModel::FindOrFail($id);
        $request['status'] = 2;
        $pengeluaran->update($request->all());
        if($pengeluaran){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diACC !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diACC !!');
        }
        return redirect('barang-keluar');
    }

    public function Tolak(Request $request, $id){
        $pengeluaran = PengeluaranModel::FindOrFail($id);
        $request['status'] = 3;
        $pengeluaran->update($request->all());
        if($pengeluaran){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diTolak !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diTolak !!');
        }
        return redirect('barang-keluar');
    }

    public function delete($id){
        $pengeluaran = PengeluaranModel::FindOrFail($id);
        foreach ($pengeluaran->detailPengeluaranRelasi as $detail) {
            $barangId = $detail->barang_id;
            $jumlahDihapus = $detail->jumlah;
            $detail->delete();
        }   
        // Menghapus pembelian
    $pengeluaran->delete();
    if ($pengeluaran) {
        Session::flash('status', 'success');
        Session::flash('pesan', 'Data berhasil dihapus !!');
    } else {
        Session::flash('status', 'error');
        Session::flash('pesan', 'Data Gagal dihapus !!');
    }
    return redirect('/barang-keluar');
    }

    public function LaporanPengeluaran(){
        $pengeluaran = PengeluaranModel::with('userRelasi')->where('status', 2)->get();
        return view('Laporan.barang keluar.pengeluaran', [
            'data' => $pengeluaran
        ]);
    }

    public function getBarangPengeluaran(Request $request){
        $barang=[];
        if ($search = $request->name) {
            $barang = StokModel::with('barangRelasi')
                ->whereHas('barangRelasi', function ($query) use ($search) {
                    $query->where('nama_barang', 'LIKE', "%$search%");
                })
                ->get();
        } else {
            $barang = StokModel::with('barangRelasi')->get();
        }
    
        return response()->json($barang);
    }

    public function LaporanPengeluaranView($id){
        $pengeluaran = DetailPengeluaranModel::with(['barangRelasi.satuanRelasi', 'pengeluaranRelasi'])->where('barangkeluar_id', $id)->get();
        $tgl_pengeluaran = PengeluaranModel::with('userRelasi')->FindOrFail($id);
        return view('Laporan.barang keluar.pengeluaran-view', [
            'data_pengeluaran' => $tgl_pengeluaran,
            'data' => $pengeluaran,
        ]);
    }

    public function ExportPDF($id){
        $data_detail = DetailPengeluaranModel::with(['barangRelasi.satuanRelasi', 'pengeluaranRelasi'])->where('barangkeluar_id', $id)->get();
        $data_pengeluaran = PengeluaranModel::with('userRelasi')->FindOrFail($id);
        $datax = [
            'data_1' => $data_detail,
            'data_2' => $data_pengeluaran,
        ];
        $pdf = app('dompdf.wrapper');
        $pdf = pdf::loadView('laporan.barang keluar.pengeluaran-export-pdf', $datax);
        return $pdf->stream();
    }

    public function FilterBarangKeluar(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Lakukan pengambilan data dengan filter berdasarkan tanggal
        $filteredData = PengeluaranModel::with('detailPengeluaranRelasi.barangRelasi.satuanRelasi')->whereBetween('tgl', [$start_date, $end_date])->where('status', 2)->get();

        // Kemudian kembalikan data yang telah difilter sebagai respons
        return view('Laporan.barang keluar.pengeluaran', [
            'data' => $filteredData,
            'start_date' =>$start_date,
            'end_date' => $end_date
        ]);
    }

    public function ExportAllPDFFilter($start_date, $end_date){
        $pembelian = PengeluaranModel::with('detailPengeluaranRelasi.barangRelasi.satuanRelasi')
        ->whereBetween('tgl', [$start_date, $end_date])
        ->where('status', 2)
        ->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('Laporan.barang keluar.pengeluaran-export-all-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

    public function ExportAllPDF(){
        $pembelian = PengeluaranModel::with('detailPengeluaranRelasi.barangRelasi.satuanRelasi')->where('status', 2)->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('Laporan.barang keluar.pengeluaran-export-all-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

}
