<?php

namespace App\Providers;

use App\Models\PengeluaranModel;
use App\Models\StokModel;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotifServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function($view){
            $notif_acc_akun = User::where('status', 1)->count();
            $notif_barang_keluar = PengeluaranModel::where('status', 1)->count();
            $notif_sisa_stok = StokModel::where('sisa_stok', '<=', 0)->count();
            $view->with([
                'notif_acc_akun' => $notif_acc_akun,
                'notif_barang_keluar' => $notif_barang_keluar,
                'notif_sisa_stok' => $notif_sisa_stok

            ]);
        });
    }
}
