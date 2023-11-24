<?php

namespace App\Http\Controllers;

use App\Models\SatuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SatuanController extends Controller
{
    public function index(){
       $satuan = SatuanModel::get();
       return view('satuan.satuan', [
        'data' => $satuan
       ]);
    }

    public function store(Request $request){
        $satuan = satuanModel::create($request->all());
        if($satuan){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil ditambah !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal ditambah !!');
        }
        return redirect('satuan');
    }

    public function delete($id){
        $satuan = SatuanModel::FindOrFail($id);
        $satuan->delete();
        if($satuan){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil dihapus !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal dihapus !!');
        }
        return redirect('satuan');
    }

    public function update(Request $request, $id){
        $satuan = satuanModel::FindOrFail($id);
        $satuan->update($request->all());
        if($satuan){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diubah !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diubah !!');
        }
        return redirect('satuan');
    }
}
