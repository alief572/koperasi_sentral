@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_pengeluaran_modal">
            <i class="fa fa-plus"></i>
            Tambah Pengeluaran
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th class="text-center">No</th>
            <th class="text-center">Nama Karyawan</th>
            <th class="text-center">Tgl Pengeluaran</th>
            <th class="text-center">Nilai Pengeluaran</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>

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
                    <div class="modal-body" id="addPengeluaranTabunganMB">
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
                dropdownParent: $("#addPengeluaranTabunganMB")
            });

            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_pengeluaran_tabungan') }}",
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

            $(document).on("click", ".add_pengeluaran_modal", function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('add_pengeluaran_modal') }}",
                    cache: false,
                    beforeSend: function(result) {
                        $('.add_pengeluaran_modal').html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPengeluaranTabunganMB").html(result);
                        $(".modal_title_add").text('Buat Pengeluaran');
                        $(".type_post").val('POST');
                        $("#addPengeluaran").modal('show');

                        $('.add_pengeluaran_modal').html(
                            '<i class="fa fa-plus"></i> Tambah Pengeluaran');

                        $(".simpan").show();
                    }
                })
            });

            $(document).on("click", ".view", function() {

                var id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: "{{ route('view_pengeluaran_tabungan') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $(".view_" + id).html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPengeluaranTabunganMB").html(result);
                        $(".modal_title_add").text('Data Pengeluaran tabungan');
                        $("#addPengeluaran").modal('show');

                        $(".view_" + id).html(
                            '<i class="fa fa-eye"></i>');
                        $(".simpan").hide();
                    }
                });
            });

            $(document).on("click", ".edit_pengeluaran_tabungan", function() {

                var id = $(this).data("id");
                // alert(id);

                $.ajax({
                    type: "GET",
                    url: "{{ route('edit_pengeluaran_tabungan_modal') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $(".edit_pengeluaran_tabungan_" + id).html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $("#addPengeluaranTabunganMB").html(result);
                        $(".modal_title_add").text('Data Pengeluaran tabungan');
                        $("#addPengeluaran").modal('show');

                        $(".edit_pengeluaran_tabungan_" + id).html(
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
                                url: "{{ route('save_pengeluaran_tabungan') }}",
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    if (hasil.status == '1') {
                                        Swal.fire(hasil.msg,
                                            "", "success").then((hasil1) => {
                                            $("#addPengeluaran").modal('hide');
                                            dataTable.ajax.reload();
                                        });
                                    } else {
                                        Swal.fire(hasil.msg,
                                            "", "error").then((hasil1) => {
                                            // $("#addPengeluaran").modal('hide');
                                            // dataTable.ajax.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "Failed",
                                        text: "Maaf, pengeluaran tabungan gagal dibuat, silahkan dicoba kembali !",
                                        icon: "error"
                                    }).then((hasil1) => {
                                        // $("#addPengeluaran").modal('hide');
                                        // dataTable.ajax.reload();
                                    });
                                }
                            });
                        } else {
                            $.ajax({
                                url: "{{ route('edit_pengeluaran_tabungan') }}",
                                type: "PUT",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    if (hasil.status == '1') {
                                        Swal.fire(hasil.msg,
                                            "", "success").then((hasil1) => {
                                            $("#addPengeluaran").modal('hide');
                                            dataTable.ajax.reload();
                                        });
                                    } else {
                                        Swal.fire(hasil.msg,
                                            "", "error").then((hasil1) => {
                                            // $("#addPengeluaran").modal('hide');
                                            // dataTable.ajax.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "Failed",
                                        text: "Maaf, pengeluaran tabungan gagal dibuat, silahkan dicoba kembali !",
                                        icon: "error"
                                    }).then((hasil1) => {
                                        // $("#addPengeluaran").modal('hide');
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

            $(document).on("click", ".del_pengeluaran", function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin hapus pengeluaran ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('del_pengeluaran_tabungan') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            cache: false,
                            dataType: "json",
                            beforeSend: function(result) {
                                $(".del_pengeluaran_" + id).html(
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
                                    title: "Hapus Pengeluaran Gagal !",
                                    text: "Maaf, hapus pengeluaran gagal, silahkan coba lagi !"
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
                    title: "Anda yakin ingin approve pengeluaran tabungan ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Approve",
                    cancelButtonText: "Batal"

                }).then((hasil) => {
                    if (hasil.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('approval_pengeluaran_tabungan') }}",
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
                                    title: "Approve Pengeluaran Gagal !",
                                    text: "Maaf, approve pengeluaran gagal, silahkan coba lagi !"
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.get_tabungan', function() {
                var id_karyawan = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_tabungan_pengeluaran') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_karyawan': id_karyawan
                    },
                    cache: false,
                    success: function(result) {
                        $('.nilai_tabungan_karyawan').html('Rp. ' + result);
                    },
                    error: function(result) {
                        swal.fire({
                            title: 'Error',
                            text: 'Maaf, ada kesalahan teknis !',
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@endsection
