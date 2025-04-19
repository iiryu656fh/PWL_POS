@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('stok/import') }}')" class="btn btn-sm btn-info mt-1">Import Stok</button>
                    <a href="{{ url('stok/export_excel')}}" class="btn btn-primary"><i class="fas fa-file-excel"></i> Export Stok Excel</a>
                    <a href="{{ url('stok/export_pdf')}}" class="btn btn-warning"><i class="fas fa-file-pdf"></i> Export Stok PDF</a>
                    <button onclick="modalAction('{{ url('stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <!-- untuk filter data -->
                <div id="filter" class="form-horizontal  filter-date p-2 border-bottom mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select name="supplier_id" class="form-control" id="supplier_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($supplier as $item)
                                            <option value="{{ $item->supplier_id}}">{{ $item->supplier_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Supplier barang</small>
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
                <table class="table table-bordered table-striped table-hover table-sm" id="data_stok">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Supplier</th>
                            <th>Barang</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url='') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataStok;
        $(document).ready(function () {
            dataStok = $('#data_stok').DataTable({
                // Serverside: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('stok/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.supplier_id = $('#supplier_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }, {
                        data: "supplier.supplier_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "barang.barang_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "user.nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "stok_tanggal",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "stok_jumlah",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "aksi",
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#supplier_id').on('change', function () {
                dataStok.ajax.reload();
            });
        });
    </script>
@endpush