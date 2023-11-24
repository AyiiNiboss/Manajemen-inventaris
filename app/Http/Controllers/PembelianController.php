<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use App\Models\PembelianModel;
use App\Models\DetailPembelianModel;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    public function index(){
        $pembelian = PembelianModel::with('supplierRelasi')->get();
        return view('pembelian.pembelian', [
            'data' => $pembelian
        ]);
    }

    public function delete($id){
        $pembelian = PembelianModel::FindOrFail($id);
         // Menghapus detail pembelian dan mengurangkan stok
        foreach ($pembelian->detailPembelianRelasi as $detail) {
            $obatId = $detail->barang_id;
            $jumlahDihapus = $detail->jumlah;

            // Mengurangkan stok obat
            $existingStock = StokModel::where('barang_id', $obatId)->first();
            
            if ($existingStock) {
                $existingStock->sisa_stok -= $jumlahDihapus;
                $existingStock->save();
            }
            
            // Menghapus detail pembelian
            $detail->delete();
        }   
        // Menghapus pembelian
    $pembelian->delete();
    if ($pembelian) {
        Session::flash('status', 'success');
        Session::flash('pesan', 'Data berhasil dihapus !!');
    } else {
        Session::flash('status', 'error');
        Session::flash('pesan', 'Data Gagal dihapus !!');
    }
    return redirect('/barang-masuk');
    }

    public function view($id){
        $pembelian = DetailPembelianModel::with(['barangRelasi.satuanRelasi', 'pembelianRelasi'])->where('barangmasuk_id', $id)->get();
        $tgl_pembelian = PembelianModel::with('supplierRelasi')->FindOrFail($id);
        return view('pembelian.pembelian-view', [
            'data_pembelian' => $tgl_pembelian,
            'data' => $pembelian
        ]);

    }

    public function create(){
        return view('pembelian.pembelian-add');
    }

    public function getBarang(Request $request){
        $barang=[];
        if($search=$request->name){
            $barang=BarangModel::where('nama_barang', 'LIKE', "%$search%")->get();
        }else{
            $barang = BarangModel::all();
        }
        return response()->json($barang);
    }

    public function getData($id){
        $barang = BarangModel::with('satuanRelasi')->FindOrFail($id);
        return response()->json($barang);
    }

    public function getSupplier(Request $request){
        $supplier=[];
        if($search=$request->name){
            $supplier=SupplierModel::where('nama_supplier', 'LIKE', "%$search%")->get();
        }else{
            $supplier = SupplierModel::all();
        }
        return response()->json($supplier);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'tgl' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
            'supplier_id' => 'required',
        ], [
            'tgl.required' => 'Tanggal masuk barang harus diisi.',
            'barang_id.*.required' => 'Nama barang harus diisi.',
            'jumlah.*.required' => 'Jumlah barang harus diisi.',
            'supplier_id.required' => 'Nama supplier barang harus diisi.',
        ]);

        // Simpan data pembelian
        $pembelian = new PembelianModel();
        $pembelian->tgl = $validatedData['tgl'];
        $pembelian->supplier_id = $validatedData['supplier_id'];
        $pembelian->catatan = $request->input('catatan');
        $pembelian->save();

        // Simpan detail pembelian
        foreach ($validatedData['barang_id'] as $key => $barangId) {
            $detailPembelian = new DetailPembelianModel();
            $detailPembelian->barangmasuk_id = $pembelian->id;
            $detailPembelian->barang_id = $barangId;
            $detailPembelian->jumlah = $validatedData['jumlah'][$key];
            // tambahkan data lainnya sesuai kebutuhan
            $detailPembelian->save();
            
            // stok barang
            $existingStock= StokModel::where('barang_id', $barangId)->first();
            if ($existingStock) {
                // Jika data stok sudah ada, perbarui stoknya
                $existingStock->sisa_stok += $validatedData['jumlah'][$key];
                $existingStock->save();
            } else {
                $stok = new StokModel();
                $stok->barang_id = $barangId;
                $stok->tgl_masuk = $pembelian->tgl;
                $stok->sisa_stok = $validatedData['jumlah'][$key];
                $stok->save();
            }
        }

        if ($pembelian) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil ditambah !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal ditambah !!');
        }

        return redirect('/barang-masuk');
    }

    public function LaporanPembelian(){
        $pembelian = PembelianModel::with('detailPembelianRelasi.barangRelasi.satuanRelasi')->get();
        return view('Laporan.barang masuk.pembelian', [
            'data' => $pembelian
        ]);
    }

    public function LaporanPembelianView($id){
        $pembelian = DetailPembelianModel::with(['barangRelasi.satuanRelasi', 'pembelianRelasi'])->where('barangmasuk_id', $id)->get();
        $tgl_pembelian = PembelianModel::with('supplierRelasi')->FindOrFail($id);
        return view('Laporan.barang masuk.pembelian-view', [
            'data_pembelian' => $tgl_pembelian,
            'data' => $pembelian
        ]);
    }

    public function FilterBarangMasuk(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Lakukan pengambilan data dengan filter berdasarkan tanggal
        $filteredData = PembelianModel::with('detailPembelianRelasi.barangRelasi.satuanRelasi')->whereBetween('tgl', [$start_date, $end_date])->get();

        // Kemudian kembalikan data yang telah difilter sebagai respons
        return view('Laporan.barang masuk.pembelian', [
            'data' => $filteredData,
            'start_date' =>$start_date,
            'end_date' => $end_date
        ]);
    }

    public function ExportPDF($id){
        $data_detail = DetailPembelianModel::with(['barangRelasi.satuanRelasi', 'pembelianRelasi'])->where('barangmasuk_id', $id)->get();
        $data_pembelian = PembelianModel::with('supplierRelasi')->FindOrFail($id);
        $datax = [
            'data_1' => $data_detail,
            'data_2' => $data_pembelian,
        ];
        $pdf = app('dompdf.wrapper');
        $pdf = pdf::loadView('Laporan.barang masuk.pembelian-export-pdf', $datax);
        return $pdf->stream();
    }

    public function ExportAllPDF(){
        $pembelian = PembelianModel::with('detailPembelianRelasi.barangRelasi.satuanRelasi')->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('Laporan.barang masuk.pembelian-export-all-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

    public function ExportAllPDFFilter($start_date, $end_date){
        $pembelian = PembelianModel::with('detailPembelianRelasi.barangRelasi.satuanRelasi')
        ->whereBetween('tgl', [$start_date, $end_date])
        ->get();
        $datax = [
            'data' => $pembelian
        ];
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('landscape');
        $pdf = pdf::loadView('Laporan.barang masuk.pembelian-export-all-pdf', $datax)->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }
}
