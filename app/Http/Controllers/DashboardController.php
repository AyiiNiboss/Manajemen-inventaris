<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\PengeluaranModel;
use App\Models\StokModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $barangmasuk = PembelianModel::get()->count();
        $barangkeluar = PengeluaranModel::where('status', 2)->get()->count();
        $stokbarang = StokModel::get()->count();
        $user = User::where('status', 2)->get()->count();
        return view('dashboard.dashboard', [
            'data_pembelian' => $barangmasuk,
            'data_pengeluaran' => $barangkeluar,
            'data_stok' => $stokbarang,
            'data_user' => $user
        ]);
    }
}
