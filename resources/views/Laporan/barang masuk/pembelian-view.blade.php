@extends('layout.main')
@section('content')

    
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">laporan /</span> Laporan Barang Masuk
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Pembelian Barang</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th width="20px">Tanggal</th>
                            <th>: {{ Carbon\Carbon::parse($data_pembelian->tgl)->translatedFormat('d F Y') }}</th>
                        </tr>
                        <tr>
                            <th>SUPPLIER</th>
                            <th>: {{ $data_pembelian->supplierRelasi->nama_supplier }}</th>
                        </tr>
                        <tr>
                            <th>NOMOR TELEPON</th>
                            <th>: {{ $data_pembelian->supplierRelasi->no_telpon ? $data_pembelian->supplierRelasi->no_telpon : '-' }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="container">
            {{-- <h5 class="text-center">Data Kosong</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="@if(\Illuminate\Support\Facades\Request::is('sm*')) table @else table table-bordered @endif">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama barang</th>
                            <th class="text-center">jumlah</th>
                            <th class="text-center">harga satuan</th>
                            <th class="text-center">Total harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotal = 0;
                        @endphp
            
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->barangRelasi->kode_barang }}</td>
                                <td>{{ $item->barangRelasi->nama_barang }}</td>
                                <td class="text-center">{{ $item->jumlah }} {{ $item->barangRelasi->satuanRelasi->nama_satuan }}</td>
                                <td class="text-center">@money($item->barangRelasi->harga_satuan)</td>
                                <td class="text-center">@money($item->jumlah * $item->barangRelasi->harga_satuan)</td>
                            </tr>
                            @php
                                $grandTotal += $item->jumlah * $item->barangRelasi->harga_satuan;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center" style="font-weight: 600">TOTAL </td>
                            <td class="text-center">@money($grandTotal)</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="mx-3 my-3">
            <a href="{{ route('laporan-pembelian') }}" class="btn btn-info">Kembali</a>
        </div>
    </div>
</div>
@endsection