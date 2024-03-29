@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_pemasukan_modal">
            <i class="fa fa-plus"></i>
            Tambah Pemasukan
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Karyawan</th>
            <th class="text-center">Tgl Pemasukan</th>
            <th class="text-center">Nilai Pemasukan</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addPemasukan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Karyawan</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addPemasukanTabunganMB">
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
            $(".chosen-select").select2({
                width: '100%',
                dropdownParent: $("#addPemasukanTabunganMB")
            });

            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_pemasukan_tabungan') }}",
                    type: "GET",
                    dataType: "JSON",
                    data: function(d) {
                        d.search = $(".dtb_search").val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'no',
                        className: 'text-center'
                    },
                    {
                        data: 'nm_karyawan',
                        className: 'text-center'
                    },
                    {
                        data: 'tgl',
                        className: 'text-center'
                    },
                    {
                        data: 'nilai',
                        className: 'text-center'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'buttons',
                        className: 'text-center'
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
                pageLength: 10
            });

            $(document).on("click", ".add_pemasukan_modal", function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('add_pemasukan_modal') }}",
                    cache: false,
                    beforeSend: function(result) {
                        $('.add_pemasukan_modal').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPemasukanTabunganMB").html(result);
                        $(".modal_title_add").text('Buat Pemasukan');
                        $(".type_post").val('POST');
                        $("#addPemasukan").modal('show');

                        $('.add_pemasukan_modal').html(
                            '<i class="fa fa-plus"></i> Tambah Pemasukan');

                        $(".simpan").show();
                    }
                })
            });

            $(document).on("click", ".view", function() {

                var id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: "{{ route('view_pemasukan_tabungan') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $(".view_" + id).html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPemasukanTabunganMB").html(result);
                        $(".modal_title_add").text('Data Pemasukan tabungan');
                        $("#addPemasukan").modal('show');

                        $(".view_" + id).html(
                            '<i class="fa fa-eye"></i>');
                        $(".simpan").hide();
                    }
                });
            });

            $(document).on("click", ".edit_pemasukan_tabungan", function() {

                var id = $(this).data("id");
                // alert(id);

                $.ajax({
                    type: "GET",
                    url: "{{ route('edit_pemasukan_tabungan_modal') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $(".edit_pemasukan_tabungan_" + id).html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPemasukanTabunganMB").html(result);
                        $(".modal_title_add").text('Data Pemasukan tabungan');
                        $("#addPemasukan").modal('show');

                        $(".edit_pemasukan_tabungan_" + id).html(
                            '<i class="fa fa-pencil"></i>');
                        $(".simpan").show();
                    }
                });
            });

            $(document).on("submit", "#data_form", function(e) {
                e.preventDefault();
                var type_post = $(".type_post").val();

                Swal.fire({
                    icon: "warning",
                    title: "Anda sudah yakin ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        if (type_post == "POST") {
                            $.ajax({
                                url: "{{ route('save_pemasukan_tabungan') }}",
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    if (hasil.status == '1') {
                                        Swal.fire(hasil.msg,
                                            "", "success").then((hasil1) => {
                                            $("#addPemasukan").modal('hide');
                                            dataTable.ajax.reload();
                                        });
                                    } else {
                                        Swal.fire(hasil.msg,
                                            "", "error").then((hasil1) => {
                                            // $("#addPemasukan").modal('hide');
                                            // dataTable.ajax.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "Failed",
                                        text: "Maaf, pemasukan tabungan gagal dibuat, silahkan dicoba kembali !",
                                        icon: "error"
                                    }).then((hasil1) => {
                                        // $("#addPemasukan").modal('hide');
                                        // dataTable.ajax.reload();
                                    });
                                }
                            });
                        } else {
                            $.ajax({
                                url: "{{ route('edit_pemasukan_tabungan') }}",
                                type: "PUT",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    if (hasil.status == '1') {
                                        Swal.fire(hasil.msg,
                                            "", "success").then((hasil1) => {
                                            $("#addPemasukan").modal('hide');
                                            dataTable.ajax.reload();
                                        });
                                    } else {
                                        Swal.fire(hasil.msg,
                                            "", "error").then((hasil1) => {
                                            // $("#addPemasukan").modal('hide');
                                            // dataTable.ajax.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "Failed",
                                        text: "Maaf, pemasukan tabungan gagal dibuat, silahkan dicoba kembali !",
                                        icon: "error"
                                    }).then((hasil1) => {
                                        // $("#addPemasukan").modal('hide');
                                        // dataTable.ajax.reload();
                                    });
                                }
                            });
                        }
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on("click", ".del_pemasukan", function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin hapus pemasukan ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('del_pemasukan_tabungan') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            cache: false,
                            dataType: "json",
                            beforeSend: function(result) {
                                $(".del_pemasukan_" + id).html(
                                    "<i class='fa fa-spin fa-spinner'></i>");
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: result.return_color,
                                    title: result.title_return,
                                    text: result.msg
                                }).then((result1) => {
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(result) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Hapus Pemasukan Gagal !",
                                    text: "Maaf, hapus pemasukan gagal, silahkan coba lagi !"
                                });
                            }
                        });
                    }
                });
            });

            $(document).on("click", ".approval", function() {
                var id = $(this).data("id");

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin approve pemasukan tabungan ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Approve",
                    cancelButtonText: "Batal"

                }).then((hasil) => {
                    if (hasil.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('approval_pemasukan_tabungan') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            cache: false,
                            dataType: "json",
                            beforeSend: function(result) {
                                $(".approval_" + id).html(
                                    "<i class='fa fa-spin fa-spinner'></i>");
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: result.return_color,
                                    title: result.title_return,
                                    text: result.msg
                                }).then((result1) => {
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(result) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Approve Pemasukan Gagal !",
                                    text: "Maaf, approve pemasukan gagal, silahkan coba lagi !"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
