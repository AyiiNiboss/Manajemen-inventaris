<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style type="text/css">
    @page {
        margin-top: 1cm;
        margin-left: 1.5cm;
        margin-right: 1.5cm;
        margin-bottom: 0.1cm;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        font-family: Arial, Helvetica, sans-serif, arial, sans-serif;
        /* font-size: 14px; */
        color: #333333;
        /* border-width: none; */
        border-collapse: collapse;
        width: 100%;
        
    }

    th {
        padding-bottom: 8px;
        padding-top: 8px;
        padding-left: 3px;
        padding-right: 3px;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 600;
        
    }

    .table th {
        text-transform: uppercase;
        font-size: .75rem;
        letter-spacing: 1px;
    }

    .table td {
        font-size: 0.75rem;
        letter-spacing: 1px;
    }


    h5 {
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .table-bordered> :not(caption)>* {
        border-width: 1px 0;
    }

   
</style>

<body>
    <div class="row">
        <div class="col">
            <table class="table table-borderless" style="margin-bottom:50px">
                <thead>
                    <tr>
                        <th style="text-align: left"></th>
                        {{-- <th style="width: 40%">Palembang, {{ Carbon\Carbon::parse($data->tgl)->translatedFormat('d
                            F Y'); }}</th> --}}
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="width: 100%;text-align:center;font-size: 16px">PEMBELIAN BARANG</th>
                    </tr>
                </thead>
            </table>
            <table class="table table-borderless">
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td style="width: 20%;padding: 5px">Tanggal</td>
                        <td style="padding: 5px">: {{ Carbon\Carbon::parse($data_2->tgl)->translatedFormat('d F Y'); }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">Supplier</td>
                        <td style="padding: 5px">: {{ $data_2->supplierRelasi->nama_supplier }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px">Nomor Telepon</td>
                        <td style="padding: 5px">: {{ $data_2->supplierRelasi->no_telpon }}</td>
                    </tr>

                </tbody>
            </table>
            <table class="table content-table" style="">
                <thead>
                    <tr>
                        <th style=" border: 1px solid #ddd; text-align: center;">KODE</th>
                        <th style=" border: 1px solid #ddd; text-align: center;">NAMA</th>
                        <th style=" border: 1px solid #ddd; text-align: center;">JUMLAH</th>
                        <th style=" border: 1px solid #ddd; text-align: center;">HARGA SATUAN</th>
                        <th style=" border: 1px solid #ddd; text-align: center;">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $grandTotal = 0;
                    @endphp

                    @foreach ($data_1 as $item)
                    <tr>
                        <td style=" border: 1px solid #ddd;text-align: center; padding: 10px">{{ $item->barangRelasi->kode_barang }}</td>
                        <td style=" border: 1px solid #ddd;padding: 10px">{{ $item->barangRelasi->nama_barang }}</td>
                        <td style=" border: 1px solid #ddd;padding: 10px">{{ $item->jumlah }} {{ $item->barangRelasi->satuanRelasi->nama_satuan }}
                        </td>
                        <td style=" border: 1px solid #ddd;padding: 10px">@money($item->barangRelasi->harga_satuan)</td>
                        <td style=" border: 1px solid #ddd;padding: 10px">@money($item->jumlah * $item->barangRelasi->harga_satuan)</td>
                    </tr>
                    @php
                    $grandTotal += $item->jumlah * $item->barangRelasi->harga_satuan;
                    @endphp
                    @endforeach

                    <!-- Tambahkan baris-baris data sesuai dengan kebutuhan -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center" style="font-weight: 600; border: 1px solid #ddd;padding: 10px">TOTAL </td>
                        <td class="text-center" style=" border: 1px solid #ddd;padding: 10px">@money($grandTotal)</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>

        </div>
    </div>
    <br><br>
    </table>
    {{-- <table class="table table-borderless" style="margin-left: 50px;">
        <thead>
            <tr>
                <th style="text-align: left"></th>
                <th style="width: 40%">Palembang, {{ Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y');
                    }}</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th style="text-align: left"></th>
                <th style="width: 40%">An CAMAT EMPAT PETULAI DANGKU</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <tr>
                <td style=""></td>
                <td></td>
            </tr>
            <tr>
                <td style=""></td>
                <td>Arman Sarijaya, S.H</td>
            </tr>
        </tbody>
    </table> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>