@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('barang/import') }}')" class="btn btn-sm btn-info mt-1">Import
                        Barang</button>
                    <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
                    <button onclick="modalAction('{{ url('barang/create_ajax') }}')"
                        class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <!-- untuk filter data -->
                <div id="filter" class="form-horizontal  filter-date p-2 border-bottom mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm row text-sm mb-0">
                                <label for="filter_date" class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                        <option value="">- Semua -</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->kategori_id}}">{{ $item->kategori_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Kategori barang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <table class="table table-bordered table-striped table-hover table-sm" id="data_barang">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%"></div>
@endsection

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }

            var dataBarang;
            $(document).ready(function () {
                dataBarang = $('#data_barang').DataTable({
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('barang/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.kategori_id = $('.filter_kategori').val();
                        }
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            className: 'text-center',
                            width: "5%",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "barang_kode",
                            className: "",
                            width: "10%",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "barang_nama",
                            className: "",
                            width: "37%",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "kategori.kategori_nama",
                            className: "",
                            width: "14%",
                            orderable: true,
                            searchable: false
                        }, {
                            data: "harga_beli",
                            className: "",
                            width: "10%",
                            orderable: true,
                            searchable: false,
                            render: function (data, type, row) {
                                return new Intl.NumberFormat('id-ID').format(data);
                            }
                        }, {
                            data: "harga_jual",
                            className: "",
                            width: "10%",
                            orderable: true,
                            searchable: false,
                            render: function (data, type, row) {
                                return new Intl.NumberFormat('id-ID').format(data);
                            }
                        }, {
                            data: "aksi",
                            className: '',
                            width: "14%",
                            orderable: false,
                            searchable: false
                        }

                    ]
                });

                $('#data-barang_filter input').unbind().bind().on('keyup', function (e) {
                    if (e.keyCode == 13) { // enter key
                        dataBarang.search(this.value).draw();
                    }
                });
                $('.filter_kategori').change(function () {
                    dataBarang.ajax.draw();
                });
            });
        </script>
    @endpush