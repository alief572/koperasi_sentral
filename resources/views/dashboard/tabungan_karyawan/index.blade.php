@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-left">Nama Karyawan</th>
            <th class="text-center">Saldo Tabungan</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>
            {{-- {{dd($data_tabungan_karyawan)}} --}}
            @foreach ($data_tabungan_karyawan as $tabungan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $tabungan->nm_karyawan }}</td>
                    <td class="text-center">
                        {{ number_format($tabungan->nilai_pemasukan - $tabungan->nilai_pengeluaran, 2) }}</td>
                    <td class="text-center">
                        <button type="button"
                            class="btn btn-sm btn-info view_tabungan view_tabungan_{{ $tabungan->id_karyawan }}"
                            data-id_karyawan="{{ $tabungan->id_karyawan }}">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="addPengeluaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Karyawan</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addTabunganMB">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger batal" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Tabungan Karyawan</h5>
                </div>

                <div class="modal-body modal_body_view">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript_section')
    <script>
        $(document).ready(function() {
            $(".chosen-select").select2({
                width: '100%',
                dropdownParent: $("#addTabunganMB")
            });

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $(".data-table").DataTable();

            $(document).on('click', '.view_tabungan', function() {
                var id_karyawan = $(this).data('id_karyawan');
                $.ajax({
                    type: 'GET',
                    url: '{{ route("view_tabungan_karyawan") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_karyawan: id_karyawan
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $('.view_tabungan_' + id_karyawan).html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(result) {
                        $('.modal_body_view').html(result);
                        $('#viewBarang').modal('show');
                        $('.view_tabungan_' + id_karyawan).html(
                            '<i class="fa fa-eye"></i>');
                    },
                    error: function(result) {
                        Swal.fire({
                            title: 'Error !',
                            text: 'Maaf, terjadi kendala teknis, mohon dicoba kembali !',
                            icon: 'error'
                        });

                        $('.view_tabungan_' + id_karyawan).html(
                            '<i class="fa fa-eye"></i>');
                    }
                });
            });
        });
    </script>
@endsection
