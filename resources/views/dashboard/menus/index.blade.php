@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_menus">
            <i class="fa fa-plus"></i>
            {{ $list_menus }}
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>ID Menu</th>
            <th>Nama Menu</th>
            <th>Link</th>
            <th>Parent ID</th>
            <th>Permission ID</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addMenus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Menu</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addMenusMB">
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
            $(".chosen-select").select2({
                width: '100%',
                dropdownParent: $("#addMenusMB")
            });

            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_menus') }}",
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
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'link'
                    },
                    {
                        data: 'parent_id'
                    },
                    {
                        data: 'permission_id'
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

            $(document).on('click', '.add_menus', function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('add_menus') }}",
                    cache: false,
                    beforeSend: function(result) {
                        $('.add_menus').html('<i class="fa fa-spin fa-spinner"></i>');

                    },
                    success: function(result) {
                        $('.modal_title_add').html('Tambah Menu');
                        $('#addMenusMB').html(result);
                        $('#addMenus').modal('show');

                        $('.add_menus').html('<i class="fa fa-plus"></i> Tambah');

                        $(".chosen-select").select2({
                            width: '100%',
                            dropdownParent: $("#addMenusMB")
                        });
                    },
                    error: function(result) {
                        Swal.fire({
                            title: 'Error !',
                            text: 'Maaf, telah terjadi kesalahan teknis, mohon dicoba kembali !',
                            icon: 'error'
                        });

                        $('.add_menus').html('<i class="fa fa-plus"></i> Tambah');
                    }
                });
            });

            $(document).on('click', '.del_menus', function() {
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin menghapus menu ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('del_menus') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            cache: false,
                            dataType: 'json',
                            beforeSend: function(result) {
                                $('.del_menus_' + id).html(
                                    '<i class="fa fa-spin fa-spinner"></i>');
                            },
                            success: function(result) {
                                if (result.status == '1') {
                                    Swal.fire({
                                        title: 'Success !',
                                        text: result.msg,
                                        icon: 'success'
                                    }).then((hasil_result) => {
                                        dataTable.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal !',
                                        text: result.msg,
                                        icon: 'error'
                                    }).then((hasil_result) => {
                                        dataTable.ajax.reload();
                                    });
                                }
                            },
                            error: function(result) {
                                Swal.fire({
                                    title: 'Error !',
                                    text: 'Maaf, telah terjadi kesalahan teknis, mohon dicoba kembali !',
                                    icon: 'error'
                                });

                                $('.del_menus_' + id).html(
                                    '<i class="fa fa-trash"></i>');
                            }
                        });

                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on('click', '.edit_menus', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: "{{ route('edit_modal_menus') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    success: function(result) {
                        $('.modal_title_add').html('Edit Menu');
                        $('#addMenusMB').html(result);
                        $('#addMenus').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
