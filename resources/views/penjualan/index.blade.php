@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <a href="{{ url('penjualan/export_excel')}}" class="btn btn-primary"><i class="fas fa-file-excel"></i>
                        Export Penjualan Excel</a>
                    <a href="{{ url('penjualan/export_pdf')}}" class="btn btn-warning"><i class="fas fa-file-pdf"></i>
                        Export Penjualan PDF</a>
                    <button onclick="modalAction('{{ url('penjualan/create_ajax') }}')"
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
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select name="user_id" class="form-control" id="user_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->user_id}}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">User</small>
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
                <table class="table table-bordered table-striped table-hover table-sm" id="data_penjualan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Kode Penjualan</th>
                            <th>Pembeli</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
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
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }

            var dataPenjualan;
            $(document).ready(function () {
                dataPenjualan = $('#data_penjualan').DataTable({
                    // Serverside: true, jika ingin menggunakan server side processing
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('penjualan/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.user_id = $('#user_id').val();
                        }
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            className: 'text-center',
                            orderable: false,
                            searchable: false
                        }, {
                            data: "user.nama",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "penjualan_kode",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "pembeli",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "penjualan_tanggal",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "total_harga",
                            className: "text-right",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "aksi",
                            className: 'text-center',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#user_id').on('change', function () {
                    dataPenjualan.ajax.reload();
                });
            });
        </script>
    @endpush