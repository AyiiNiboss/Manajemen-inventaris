@extends('layout.main')
@section('content')

    
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"></span> Lihat Permintaan Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Permintaan Barang</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th width="20px">Tanggal</th>
                            <th>: {{ Carbon\Carbon::parse($data_pengeluaran->tgl)->translatedFormat('d F Y') }}</th>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <th>: {{ $data_pengeluaran->userRelasi->name }}</th>
                        </tr>
                        {{-- <tr>
                            <th>NOMOR TELEPON</th>
                            <th>: {{ $data_pengeluaran->supplierRelasi->no_telpon ? $data_pengeluaran->supplierRelasi->no_telpon : '-' }}</th>
                        </tr> --}}
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
        <div class="mx-3 my-3 g-2">
            @if (!$data_pengeluaran->catatan_tolak == null)
            <div class="alert alert-danger d-flex" role="alert">
                <span class="badge badge-center rounded-pill bg-warning border-label-danger p-3 me-2">❌</span>
                <div class="d-flex flex-column ps-1">
                  <h6 class="alert-heading d-flex align-items-center mb-1">Permintaan ditolak!!</h6>
                  <span>{{ $data_pengeluaran->catatan_tolak }}</span>
                </div>
              </div>
              <a href="{{ route('barang-keluar') }}" class="btn btn-info">Kembali</a>
            @endif

            @if (Auth::user()->role_id == 1 && $data_pengeluaran->status != 2)
            <a href="{{ route('barang-keluar-acc-tampil') }}" class="btn btn-info">Kembali</a>
            <a href="{{ route('barang-keluar-acc', $data_pengeluaran->id) }}" class="btn btn-icon btn-success" fdprocessedid="svtbim" title="ACC">
                <span class="tf-icons bx bx-check"></span>
            </a>
            <button type="button" class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal09" fdprocessedid="svtbim" title="TOLAK">
                <span class="tf-icons bx bx-x"></span>
            </button>
            {{-- Modal tolak verifikasi permintaan start --}}       
            <div class="modal fade" id="basicModal09" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <form action="{{ route('barang-keluar-tolak', $data_pengeluaran->id) }}" method="POST">
                @csrf
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">Tolak Permintaan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameBasic" class="form-label">Catatan</label>
                          <textarea class="form-control" name="catatan_tolak" placeholder="Berikan alasan permintaan ditolak" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
                </div>
              </div>
              {{-- Modal tolak verifikasi permintaan end --}}
            @endif
            @if (Auth::user()->role_id == 1 && $data_pengeluaran->status == 2)
            <a href="{{ route('barang-keluar') }}" class="btn btn-info">Kembali</a>
            @endif
            @if (Auth::user()->role_id == 2 && $data_pengeluaran->status == 2)
            <a href="{{ route('barang-keluar') }}" class="btn btn-info">Kembali</a>
            @endif
        </div>
    </div>
</div>
@endsection