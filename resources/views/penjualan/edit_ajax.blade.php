@empty($penjualan)
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="myModal" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $userLogin = Auth::user();
                        $now = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
                    @endphp
                    <input type="hidden" name="user_id" value="{{ $userLogin->user_id }}">
                    <div class="form-group">
                        <label>User</label>
                        <input type="text" class="form-control" value="{{ $userLogin->nama }}" readonly>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Penjualan</label>
                        <input value="{{ $penjualan->penjualan_kode }}" type="text" name="penjualan_kode"
                            id="penjualan_kode" class="form-control" required>
                        <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Pembeli</label>
                        <input value="{{ $penjualan->pembeli }}" type="text" name="pembeli" id="pembeli"
                            class="form-control" required>
                        <small id="error-pembeli" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input value="{{ $penjualan->penjualan_tanggal }}" type="datetime-local" name="penjualan_tanggal"
                            id="penjualan_tanggal" class="form-control" required>
                        <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                    </div>

                    {{-- detail penjualan --}}
                    <hr>
                    <h5>Detail Penjualan</h5>
                    <table class="table table-bordered" id="table-barang">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th><button type="button" class="btn btn-success btn-sm" id="add-barang">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->penjualan_detail ?? [] as $detail)
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-control barang-select" required>
                                        @foreach($barang as $b)
                                        <option value="{{ $b->barang_id }}" 
                                            data-harga="{{ $b->harga_jual }}"
                                            {{ $b->barang_id == $detail->barang_id ? 'selected' : '' }}>
                                            {{ $b->barang_nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="harga[]" class="form-control harga" value="{{ $detail->harga }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control jumlah" value="{{ $detail->jumlah }}">
                                </td>
                                <td>
                                    <input type="number" name="total[]" class="form-control total" readonly>
                                </td> 
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-barang">x</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Total Harga:</td>
                                <td colspan="2">
                                    <input type="text" name="total_harga" id="total_harga" class="form-control" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {

            // langsung add
            $('#table-barang tbody tr').each(function() {
                hitungSubtotal($(this));
            });
            hitungTotal();

            //add row
            $('#add-barang').click(function () {
                let newRow = $('#table-barang tbody tr:first').clone();
                newRow.find('input').val('');
                newRow.find('select').val('');
                newRow.find('.jumlah').val('');
                $('#table-barang tbody').append(newRow);
            })

            function formatRupiah(angka) {
                return 'Rp' + angka.toLocaleString('id-ID');
            }

            function hitungSubtotal(row) {
                let harga = parseFloat(row.find('.harga').val()) || 0;
                let jumlah = parseInt(row.find('.jumlah').val()) || 0;
                let subtotal = harga * jumlah;
                row.find('.total').val(subtotal);
                return subtotal;
            }

            function hitungTotal() {
                let total = 0;
                $('#table-barang tbody tr').each(function () {
                    total += hitungSubtotal($(this));
                });
                $('#total_harga').val(formatRupiah(total));
            }

            // ambil harga jual saat pilih barang
            $('#table-barang').on('change', '.barang-select', function () {
                let harga = parseFloat($(this).find(':selected').data('harga')) || 0;
                let row = $(this).closest('tr');
                row.find('.harga').val(harga);
                hitungSubtotal(row);
                hitungTotal();
            });

            // kalkulasi total per barang
            $('#table-barang').on('input', '.jumlah', function () {
                let row = $(this).closest('tr');
                hitungSubtotal(row);
                hitungTotal();
            });

            // hapus baris
            $('#table-barang').on('click', '.remove-barang', function () {
                if ($('#table-barang tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                    hitungTotal();
                }
            });


            // validasi 
            $('#form-edit').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (res) {
                        console.log(res);  // Tambahkan untuk debugging
                        if (res.status === true) {  // Periksa jika statusnya true
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                            }).then(() => {
                                dataPenjualan.ajax.reload(); // atau reset form
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: res.message,
                            });
                        }
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg,
                        });
                    }
                });
            });
        });

    </script>
@endempty