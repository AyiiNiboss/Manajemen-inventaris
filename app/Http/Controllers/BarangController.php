<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BarangController extends Controller
{
    public function index(){
        $barang = BarangModel::get();
        $satuan = SatuanModel::get();
        return view('barang.barang', [
            'data' => $barang,
            'data_satuan' => $satuan
        ]);
    }

    public function store(Request $request){
        $barang = BarangModel::create($request->all());
        if ($barang) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil ditambah !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal ditambah !!');
        }
        return redirect('/barang');
    }

    public function update(Request $request, $id){
        $barang = BarangModel::FindOrFail($id);
        $barang->update($request->all());
        if ($barang) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diubah !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diubah !!');
        }
        return redirect('/barang');
    }

    public function delete($id){
        $barang = BarangModel::FindOrFail($id);
        $barang->delete();
        if ($barang) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil dihapus !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal dihapus !!');
        }
        return redirect('/barang');
    }
}
