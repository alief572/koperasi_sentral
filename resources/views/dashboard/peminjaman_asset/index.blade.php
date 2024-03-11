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
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Peminjaman</h5>
                </div>
                <form action="" method="post" id="data_form">
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

            $(document).on("click", ".view_barang", function() {
                var id_peminjaman_asset = $(this).data('id_peminjaman_asset');

                $.ajax({
                    type: "GET",
                    url: "/view_detail_peminjaman/" + id_peminjaman_asset,
                    cache: false,
                    success: function(result) {
                        $(".modal_body_view").html(result);
                        $("#viewBarang").modal('show');
                    }
                });
            });

            $(document).on("click", ".add_peminjaman_asset", function() {
                var id_peminjaman = $('.id_peminjaman').val();
                $.ajax({
                    type: "GET",
                    url: "/add_modal_peminjaman_asset",
                    data: {
                        'id_peminjaman': id_peminjaman
                    }
                    cache: false,
                    dataType: 'json',
                    success: function(result) {
                        $("#addPeminjamanAssetMB").html(result.modal);
                        $("#addPeminjamanAsset").modal('show');

                        $('.list_barang').html(result.hasil);
                    }
                });
            });

            $(document).on("click", ".add_asset", function() {
                var id_peminjaman_asset = $(".id_peminjaman_asset").val();
                var item_asset = $(".item_asset").val();

                $.ajax({
                    type: 'POST',
                    url: '/add_item_peminjaman_asset',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'item_asset': item_asset,
                        'id_peminjaman_asset': id_peminjaman_asset
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
                        'id_peminjaman_asset2': id_peminjaman_asset2
                    },
                    dataType: 'JSON',
                    cache: false,
                    success: function(result) {
                        $(".list_asset").html(result);
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
                                url: "/peminjaman_asset",
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    Swal.fire(hasil.success,
                                        "", "success").then((hasil1) => {
                                        $("#addPeminjamanAsset").modal('hide');
                                        dataTable.ajax.reload();
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        var errors = xhr.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            $('#' + key + '-error').text(value[
                                                0]);
                                        });
                                    }
                                }
                            });
                        } else {
                            $.ajax({
                                url: "/peminjaman_asset/" + $(".id_peminjaman_asset").val(),
                                type: "PUT",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    Swal.fire(hasil.success,
                                        "", "success").then((hasil1) => {
                                        $("#addPeminjamanAsset").modal('hide');
                                        dataTable.ajax.reload();
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        var errors = xhr.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            $('#' + key + '-error').text(value[
                                                0]);
                                        });
                                    }
                                }
                            });
                        }
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on("click", ".approve_peminjaman", function() {
                var id_peminjaman_asset = $(this).data('id_peminjaman_asset');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin approve peminjaman asset ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Approve",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/approve_peminjaman_asset/" + id_peminjaman_asset,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id_peminjaman_asset": id_peminjaman_asset
                            },
                            cache: false,
                            success: function(result) {
                                Swal.fire(result.success,
                                    "", "success").then((hasil1) => {
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        $('#' + key + '-error').text(value[
                                            0]);
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on("click", ".pengembalian_asset", function() {
                var id_peminjaman_asset = $(this).data('id_peminjaman_asset');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin asset ini sudah di kembalikan ?",
                    showCancelButton: true,
                    confirmButtonText: "Approve",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/pengembalian_asset/" + id_peminjaman_asset,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id_peminjaman_asset": id_peminjaman_asset
                            },
                            cache: false,
                            success: function(result) {
                                Swal.fire(result.success,
                                    "", "success").then((hasil1) => {
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        $('#' + key + '-error').text(value[
                                            0]);
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on("click", ".reject_peminjaman", function() {
                var id_peminjaman_asset = $(this).data('id_peminjaman_asset');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin me-reject peminjaman ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Reject",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "/reject_peminjaman/" + id_peminjaman_asset,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id_peminjaman_asset": id_peminjaman_asset
                            },
                            cache: false,
                            success: function(result) {
                                Swal.fire(result.success,
                                    "", "success").then((hasil1) => {
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        $('#' + key + '-error').text(value[
                                            0]);
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
