@extends('dashboard.partial.main')


@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_peminjaman_dana">
            <i class="fa fa-plus"></i>
            Tambah Peminjaman Dana
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Total Peminjaman</th>
            <th>Tenor</th>
            <th>Tgl Awal Peminjaman</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th style="min-width:180px;">Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addPeminjamanDana" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Peminjaman Dana</h5>
                </div>
                <form action="" method="post" id="data_form">
                    <div class="modal-body" id="addPeminjamanDanaMB">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPeminjamanDana" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Data Peminjaman</h5>
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
                    url: "{{ route('get_peminjaman_dana') }}",
                    type: "GET",
                    dataType: "JSON",
                    data: function(d) {
                        d.search = $(".dtb_search").val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'nm_karyawan'
                    },
                    {
                        data: 'nilai_peminjaman'
                    },
                    {
                        data: 'tenor'
                    },
                    {
                        data: 'tgl_peminjaman'
                    },
                    {
                        data: 'pembayaran'
                    },
                    {
                        data: 'status'
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

            $(document).on('click', '.add_peminjaman_dana', function() {
                $.ajax({
                    type: "GET",
                    url: "/add_peminjaman_dana",
                    cache: false,
                    success: function(result) {
                        $("#addPeminjamanDanaMB").html(result);
                        $("#addPeminjamanDana").modal('show');

                        $('.type_post').val('POST');
                    }
                });
            });

            $(document).on('click', '.req_approval', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin Request Approval peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/req_approval_peminjaman_dana",
                            type: "PUT",
                            data: {
                                '_token': csrfToken,
                                'id': id
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                if (hasil.status == '1') {
                                    Swal.fire(hasil.msg, "", "success").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                } else {
                                    Swal.fire(hasil.msg, "", "error").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                }
                            },
                        });
                    }
                });
            });

            $(document).on('click', '.reject_peminjaman', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin Reject Peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/reject_approval_peminjaman_dana",
                            type: "PUT",
                            data: {
                                '_token': csrfToken,
                                'id': id
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                if (hasil.status == '1') {
                                    Swal.fire(hasil.msg, "", "success").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                } else {
                                    Swal.fire(hasil.msg, "", "error").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                }
                            },
                        });
                    }
                });
            });

            $(document).on('click', '.view_peminjaman', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: '/view_peminjaman_dana',
                    data: {
                        '_token': csrfToken,
                        'id': id
                    },
                    cache: false,
                    beforeSend: function() {
                        $('.view_peminjaman_' + id).html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(result) {
                        $(".modal_body_view").html(result);
                        $("#viewPeminjamanDana").modal('show');

                        $('.view_peminjaman_' + id).html(
                            '<i class="fa fa-eye"></i>');
                    }
                });
            });

            $(document).on('click', '.edit_peminjaman', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: "/edit_peminjaman_dana",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    cache: false,
                    beforeSend: function(result) {
                        $('.edit_peminjaman_' + id).html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(result) {
                        $("#addPeminjamanDanaMB").html(result);
                        $("#addPeminjamanDana").modal('show');

                        $('.type_post').val('EDIT');
                        $('.edit_peminjaman_' + id).html(
                            '<i class="fa fa-pencil"></i>');
                    }
                });
            });

            $(document).on('click', '.del_peminjaman_dana', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin Hapus Peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/del_peminjaman_dana',
                            data: {
                                '_token': csrfToken,
                                'id': id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(hasil) {
                                if (hasil.status == '1') {
                                    Swal.fire(hasil.msg, "", "success").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                } else {
                                    Swal.fire(hasil.msg, "", "error").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.approval_peminjaman_dana', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin Approve Peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'PUT',
                            url: '/approval_peminjaman_dana',
                            data: {
                                '_token': csrfToken,
                                'id': id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(hasil) {
                                if (hasil.status == '1') {
                                    Swal.fire(hasil.msg, "", "success").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                } else {
                                    Swal.fire(hasil.msg, "", "error").then(
                                        (hasil1) => {
                                            dataTable.ajax.reload();
                                        }
                                    );
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.pembayaran_pinjaman', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: '/pembayaran_pinjaman/' + id,
                    cache: false,
                    beforeSend: function(result) {
                        $('.pembayaran_jaminan_' + id).html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(result) {
                        $("#addPeminjamanDanaMB").html(result);
                        $("#addPeminjamanDana").modal('show');

                        $('.pembayaran_jaminan_' + id).html('<i class="fa fa-money"></i>');
                    }
                });
            });

            $(document).on('click', '.complete_peminjaman', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin tutup Peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/complete_peminjaman",
                            type: "PUT",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                if (hasil.status == '1') {
                                    Swal.fire(hasil.msg,
                                        "", "success").then((hasil1) => {
                                        dataTable.ajax.reload();
                                    });
                                } else {
                                    Swal.fire(hasil.msg,
                                        "", "error").then((hasil1) => {
                                        dataTable.ajax.reload();
                                    });
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
