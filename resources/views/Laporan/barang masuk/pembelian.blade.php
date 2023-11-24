@extends('layout.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Barang Masuk
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        {{-- <h5 class="card-header">Barang Masuk</h5> --}}
        <div class="card-body">
            <div class="row mt-5">
                <div class="col-12">
                    <form action="{{ route('filter-barang-masuk') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-lg-5">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control dt-input dt-full-name" name="start_date" required>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-5">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control dt-input dt-full-name" name="end_date" required>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2 text-center d-flex align-items-end justify-content-start"
                                style="gap: 2px; margin-left: -6px">
                                <button class="dt-button add-new btn btn-info" type="submit"><span><i
                                            class="bx bx-plus me-0 me-sm-1"></i><span
                                            class="d-none d-sm-inline-block">Filter</span></span></button>
                                <a href="{{ route('laporan-pembelian') }}" class="btn btn-icon btn-dark"
                                    title="Refresh">
                                    <span class="tf-icons bx bx-refresh"></span>
                                </a>

                                @if(request('start_date') && request('end_date'))
                                <a href="{{ route('pembelian-all-pdf-filter', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-icon btn-google-plus"
                                    title="Export PDF" target="_blank">
                                    <span class="tf-icons bx bxs-file-pdf"></span>
                                </a>
                                @else
                                <a href="{{ route('pembelian-all-pdf') }}" class="btn btn-icon btn-google-plus"
                                    title="Export PDF" target="_blank">
                                    <span class="tf-icons bx bxs-file-pdf"></span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive text-nowrap mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Supplier barang</th>
                            <th class="text-center">Catatan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isEmpty())
                        <!-- Cek apakah data kosong -->
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @else
                        @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y'); }}</td>
                            <td>{{ $item->supplierRelasi->nama_supplier }}</td>
                            {{-- <td>{{ $item->obatRelasi->nama_obat }}</td> --}}
                            {{-- <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ $item->obatRelasi->satuanRelasi->name }}</td> --}}
                            <td class="text-center">{{ $item->catatan ? $item->catatan : '-' }}</td>
                            {{-- <td>
                                @foreach ($item->detailPembelianRelasi as $detail)
                                - {{ $detail->barangRelasi->nama_barang }} / {{ $detail->jumlah }} {{
                                $detail->barangRelasi->satuanRelasi->nama_satuan }}
                                @if (!$loop->last)
                                <br>
                                @endif
                                @endforeach
                            </td> --}}
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('laporan-pembelian-view', $item->id) }}"
                                        class="btn rounded-pill btn-icon btn-success" aria-label="view"
                                        data-bs-toggle="tooltip" data-bs-original-title="Lihat">
                                        <i class="bx bx-show-alt mx-1"></i>
                                    </a>
                                    <a href="{{ route('pembelian-pdf', $item->id) }}"
                                        class="btn btn-icon rounded-pill btn-google-plus" aria-label="view"
                                        data-bs-toggle="tooltip" data-bs-original-title="Export PDF" target="_blank">
                                        <i class="tf-icons bx bxs-file-pdf"></i>
                                    </a>
                                    {{-- <a href="{{ route('barang-masuk-delete', $item->id) }}"
                                        class="btn rounded-pill btn-icon btn-danger" data-bs-toggle="tooltip"
                                        aria-label="Delete" data-bs-original-title="Delete">
                                        <i class="bx bx-trash mx-1"></i>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection