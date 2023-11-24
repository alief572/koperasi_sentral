@extends('dashboard.partial.main')


@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_peminjaman_asset">
            <i class="fa fa-plus"></i>
            Tambah Peminjaman Asset
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>Tgl Awal Peminjaman</th>
            <th>Tgl Pengembalian Asset</th>
            <th>Nama Karyawan</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addPeminjamanAsset" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Karyawan</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addPeminjamanAssetMB">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Data Karyawan</h5>
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


            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_peminjaman_asset') }}",
                    type: "GET",
                    dataType: "JSON",
                    data: function(d) {
                        d.search = $(".dtb_search").val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id_peminjaman_asset'
                    },
                    {
                        data: 'tgl_awal_peminjaman'
                    },
                    {
                        data: 'tgl_pengembalian'
                    },
                    {
                        data: 'nm_karyawan'
                    },
                    {
                        data: 'sts'
                    },
                    {
                        data: 'buttons'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Add an auto-incremented number to each row
                    $('td', row).eq(0).html(dataIndex + 1);
                },
                responsive: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                destroy: true,
                paging: true,
                pageLength: 10,
            });

            $(document).on("click", ".add_peminjaman_asset", function() {
                $.ajax({
                    type: "GET",
                    url: "/add_modal_peminjaman_asset",
                    cache: false,
                    success: function(result) {
                        $("#addPeminjamanAssetMB").html(result);
                        $("#addPeminjamanAsset").modal('show');
                    }
                });
            });

            $(document).on("click", ".add_asset", function() {
                var item_asset = $(".item_asset").val();

                $.ajax({
                    type: 'POST',
                    url: '/add_item_peminjaman_asset',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'item_asset': item_asset
                    },
                    dataType: 'JSON',
                    cache: false,
                    success: function(result) {
                        $(".list_asset").html(result);
                        $(".item_asset").empty();
                    }
                });
            });

            $(document).on("click", ".del_item_asset", function() {
                var id_peminjaman_asset2 = $(this).data('id_peminjaman_asset2');

                $.ajax({
                    type: 'DELETE',
                    url: '/del_item_peminjaman_asset/' + id_peminjaman_asset2,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_peminjaman_asset2' : id_peminjaman_asset2
                    },
                    dataType: 'JSON',
                    cache: false,
                    success: function(result) {
                        $(".list_asset").html(result);
                    }
                });
            });
        });
    </script>
@endsection
