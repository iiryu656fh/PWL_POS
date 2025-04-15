@extends('layouts.template')

@section('title', 'Profil')
@section('content')

<div class="card card-outline card-primary">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/profil/import') }}')" class="btn btn-sm btn-info mt-1">Ganti Foto Profil</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    @if (Auth::user()->foto)
                             <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil"
                                 class="img-fluid rounded-circle mx-auto d-block"
                                 style="height: 200px; width: 200px; object-fit: cover;" id="preview-image">
                         @else
                             <div id="default-image"
                                 class="bg-light d-flex align-items-center justify-content-center rounded-circle mx-auto"
                                 style="height: 200px; width: 200px;">
                                 <i class="fas fa-user fa-5x text-secondary"></i>
                             </div>
                         @endif
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-borderless">
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $user->level->level_nama }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true">
</div>

@endsection

@push('js')
<script>
    function modalAction(url) {
        $('#myModal').load(url, function () {
             $('#myModal').modal('show');
         });
    }
</script>
@endpush