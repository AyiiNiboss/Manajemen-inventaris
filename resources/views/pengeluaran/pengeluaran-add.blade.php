@extends('layout.main')
@section('content')
<style>
    .select2-container .select2-selection--single .select2-selection__rendered {
        display: block;
        padding-left: 8px;
        padding-right: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .light-style .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.25rem;
        color: #697a8d;
        padding-left: 0.875rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-right: 2.25rem;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        padding-bottom: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"></span> Buat Permintaan Barang
    </h4>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Permintaan Barang</h5>
        <div class="card-body">
            <form action="{{ route('barang-keluar-proses') }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Tanggal</label>
                        <input type="date" id="nameBasic" name="tgl" class="form-control"
                            placeholder="Masukan tanggal masuk">
                        @error('tgl')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col mb-3" style="border: 1">
                        <label for="nameBasic" class="form-label">Nama</label>
                        <input type="text" id="nameSmall" name="name" value="{{ Auth::user()->name }}" class="form-control" placeholder="Enter Name" readonly>
                    </div>
                </div>
                <div id="input-groups" class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                    
                </div>                
                <div class="mb-3">
                    <button type="button" class="btn btn-warning" id="add-input">
                        Buat nama barang
                    </button>
                </div>
                <div class="row mb-3">
                    <div class="col mb-0">
                        <label for="exampleFormControlTextarea1" class="form-label">Catatan</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="catatan"
                            rows="3"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">SUBMIT</button>
            </form>
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
    function initializeSelect2(element) {
        element.select2({
            placeholder: 'Pilih nama barang',
            allowClear: true,
            ajax: {
                url: "{{ route('get-barang-pengeluaran') }}",
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            console.log(item)
                            return {
                                id: item.barang_relasi.id,
                                text: item.barang_relasi.nama_barang
                            };
                        })
                    };
                }
            }
        });
    }

    $('#add-input').click(function() {
        var newIndex = $('.tags').length;
        var newInput = `
        <div id="input-group-${newIndex}" class="d-flex border rounded position-relative pe-0 mb-4">
        <div class="row w-100 m-0 p-3">
            <div class="col-md-5 col-12 mb-md-0 mb-3 ps-md-0">
                <label for="nameBasic" class="form-label">Nama Barang</label>
                <select class="tags form-select" id="nama_barang_${newIndex}" style="padding: 12px 20px;width: 100%"
                    name="barang_id[]" aria-label="Default select example">
                </select>
            </div>
            <div class="col-md-3 col-12 mb-md-0 mb-3">
                <label for="emailBasic" class="form-label">Jumlah</label>
                <input type="number" id="emailBasic" name="jumlah[]" min="0" class="form-control"
                    placeholder="Masukan jumlah obat">
                @error('jumlah')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-2 col-12 mb-md-0 mb-3">
                <label for="dobBasic" class="form-label">Satuan</label>
                <input type="text" id="satuan" name="satuan_id[]" class="form-control" placeholder=""
                    readonly>
            </div>
            <div class="col-md-2 col-12 mb-md-0 mb-3">
                <label for="dobBasic" class="form-label">Sisa Stok</label>
                <input type="text" id="sisa_stok" name="sisa_stok[]" class="form-control" placeholder=""
                    readonly>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
            <i id="delete-input" class="bx bx-x fs-4 text-muted cursor-pointer" data-repeater-delete=""></i>
        </div>
    </div>
        `;

        $('#input-groups').append(newInput);

        var newSelect = $(`#nama_barang_${newIndex}`);
        initializeSelect2(newSelect);

        newSelect.on('change', function() {
            let nama_barang = $(this).val();
            if (nama_barang) {
                $.ajax({
                    url: '/pembelian-obat/add/' + nama_barang,
                    type: 'GET',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        let satuanInput = newSelect.closest('.row').find('[name="satuan_id[]"]');
                        satuanInput.val(data.satuan_relasi.nama_satuan);
                    }
                });
            }
        });
        $(document).on('click', '#delete-input', function() {
            $(this).closest(`#input-group-${newIndex}`).remove();
        });
    });


    // satuan input
    $(document).on('change', '.tags', function() {
        let nama_barang = $(this).val();
        let satuanInput = $(this).closest('.row').find('[name="satuan_id[]"]');
        let stokInput = $(this).closest('.row').find('[name="sisa_stok[]"]');
        console.log(nama_barang);
        if (nama_barang) {
            $.ajax({
                url: '/pengeluaran-barang/add/' + nama_barang,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    satuanInput.val(data[0].barang_relasi.satuan_relasi.nama_satuan);
                    stokInput.val(data[0].sisa_stok);
                }
            });
        }
    });
});

</script>
@endsection