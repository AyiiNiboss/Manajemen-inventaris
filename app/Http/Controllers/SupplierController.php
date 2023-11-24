<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    public function index(){
        $supplier = SupplierModel::get();
        return view('supplier.supplier', [
            'data' => $supplier
        ]);
    }

    public function delete($id){
        $supplier = SupplierModel::FindOrFail($id);
        $supplier->delete();
        if($supplier){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil dihapus !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data berhasil ditolak !!');
        }
        return redirect('/supplier');
    }

    public function store(Request $request){
        $supplier = SupplierModel::create($request->all());
        if ($supplier) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil ditambah !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal ditambah !!');
        }
        return redirect('/supplier');
    }

    public function update(Request $request, $id){
        $supplier = SupplierModel::FindOrFail($id);
        $supplier->update($request->all());
        if ($supplier) {
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diubah !!');
        } else {
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diubah !!');
        }
        return redirect('/supplier');
    }
}
