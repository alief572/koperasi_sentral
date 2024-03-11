@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_kategori_barang">
            <i class="fa fa-plus"></i>
            Tambah Kategori Barang
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>Nama Kategori Barang</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addKategoriBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_title_add" id="exampleModalLabel">Tambah Data Karyawan</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addKategoriBarangMB">
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
            // $(".chosen-select").select2({
            //     width: '100%',
            //     dropdownParent: $("#addKategoriBarangMB")
            // });

            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_kategori_barang') }}",
                    type: "GET",
                    dataType: "JSON",
                    data: function(d) {
                        d.search = $(".dtb_search").val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'nm_kategori_barang'
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

            $(document).on("click", ".add_kategori_barang", function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kategori_barang_add_modal') }}",
                    cache: false,
                    success: function(result) {
                        $("#addKategoriBarangMB").html(result);
                        $(".modal_title_add").text('Tambah Data Kategori Barang');
                        $(".type_post").val('POST');
                        $("#addKategoriBarang").modal('show');
                    }
                })
            });

            $(document).on("click", ".edit_kategori_barang", function() {
                var id_kategori_barang = $(this).data('id');
                // alert(id_kategori_barang);

                $.ajax({
                    type: "GET",
                    url: "/get_data_kategori_barang/" + id_kategori_barang,
                    cache: false,
                    success: function(result) {
                        console.log(result);
                        $("#addKategoriBarangMB").html(result);
                        $(".modal_title_add").text('Edit Data Kategori Barang');
                        $("#addKategoriBarang").modal('show');
                    }
                });
            });

            $(document).on("submit", "#delete_form", function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin hapus data barang ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: "/master_kategori_barang/" + id,
                            data: $(this).serialize(),
                            cache: false,
                            success: function(result) {
                                dataTable.ajax.reload();
                            }
                        });
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
                        if(type_post == "POST"){
                            $.ajax({
                                url: "/master_kategori_barang",
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    Swal.fire(hasil.success,
                                        "", "success").then((hasil1) => {
                                        $("#addKategoriBarang").modal('hide');
                                        dataTable.ajax.reload();
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        var errors = xhr.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            $('#' + key + '-error').text(value[0]);
                                        });
                                    }
                                }
                            });
                        }else{
                            $.ajax({
                                url: "/master_kategori_barang/" + $(".id").val(),
                                type: "PUT",
                                data: $(this).serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(hasil) {
                                    Swal.fire(hasil.success,
                                        "", "success").then((hasil1) => {
                                        $("#addKategoriBarang").modal('hide');
                                        dataTable.ajax.reload();
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 422) {
                                        var errors = xhr.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            $('#' + key + '-error').text(value[0]);
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

            $(document).on("click", ".view_barang", function() {
                var id_barang = $(this).data('id_barang');
                // alert(id_barang);
                $.ajax({
                    type: "GET",
                    url: "/get_view_barang/" + id_barang,
                    cache: false,
                    success: function(result) {
                        // console.log(result);
                        $(".modal_body_view").html(result);
                        $("#viewBarang").modal('show');
                    }
                });
            });
        });
    </script>
@endsection
