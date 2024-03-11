<div class="row">
    <div class="col-12">
        {{ csrf_field() }}
        <input type="hidden" name="id_peminjaman_dana" class="id_peminjaman_dana"
            value="<?= isset($data_peminjaman) ? $data_peminjaman->id : null ?>">
        <input type="hidden" name="type_post" class="type_post" value="<?= isset($data_peminjaman) ? 'edit' : null ?>">
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Nama Karyawan</label>
            <select name="nm_karyawan" id="" class="form-control form-control-sm chosen-select" required>
                <?php
                if (isset($data_karyawan)):
                ?>

                @foreach ($data_karyawan as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}"
                        {{ $karyawan->id_karyawan == $data_peminjaman->id_karyawan ? 'selected' : null }}>
                        {{ $karyawan->nm_karyawan }}</option>
                @endforeach

                <?php
                endif;
                ?>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Tgl Peminjaman</label>
            <input type="date" name="tgl_peminjaman" id="" class="form-control form-control-sm"
                value="{{ isset($data_peminjaman) ? $data_peminjaman->tgl_peminjaman : null }}" required>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Tipe Peminjaman</label>
            <select name="tipe_pinjaman" id="" class="form-control form-control-sm tipe_peminjaman" required>
                <option value="">- Tipe Peminjaman -</option>
                <option value="1"
                    {{ isset($data_peminjaman) && $data_peminjaman->tipe_pinjaman == '1' ? 'selected' : null }}>
                    Peminjaman Dana</option>
                <option value="2"
                    {{ isset($data_peminjaman) && $data_peminjaman->tipe_pinjaman == '2' ? 'selected' : null }}>Kredit
                    Barang</option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Nilai Peminjaman</label>
            <input type="number" name="nilai_peminjaman" id="" class="form-control form-control-sm text-right"
                value="{{ isset($data_peminjaman) ? $data_peminjaman->nilai_peminjaman : null }}" required>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Tenor Pinjaman</label>
            <select name="tenor_pinjaman" id="" class="form-control form-control-sm tenor_pinjaman" required>
                <option value="">- Tenor Pinjaman -</option>
                <option
                    value="1"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '1' ? 'selected' : null }}>
                    1 Bulan</option>
                <option
                    value="2"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '2' ? 'selected' : null }}>
                    2 Bulan</option>
                <option
                    value="3"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '3' ? 'selected' : null }}>
                    3 Bulan</option>
                <option
                    value="4"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '4' ? 'selected' : null }}>
                    4 Bulan</option>
                <option
                    value="5"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '5' ? 'selected' : null }}>
                    5 Bulan</option>
                <option
                    value="6"{{ isset($data_peminjaman) && $data_peminjaman->tenor == '6' ? 'selected' : null }}>
                    6 Bulan</option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" id="" cols="30" rows="5" class="form-control form-control-sm">{{ isset($data_peminjaman) ? $data_peminjaman->keterangan : null }}</textarea>
        </div>
    </div>


    <div
        class="col-12 table_alat {{ isset($data_peminjaman) && $data_peminjaman->tipe_pinjaman == '2' ? null : 'd-none' }}">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list_barang">
                @foreach ($barang as $item_barang)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item_barang->nama_barang }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger del_barang"
                                data-id="{{ $item_barang->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" name="" id=""
                            class="form-control form-control-sm nama_barang">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm add_barang">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(".chosen-select").select2({
        width: '100%',
        dropdownParent: $("#addPeminjamanDanaMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_peminjaman_dana_list_karyawan',
            type: 'GET',
            dataType: 'JSON',
            data: function(params) {
                return {
                    searchTerm: params.term,
                    page: params.page,
                    _token: '{{ csrf_token() }}'
                }
            },
            processResults: function(data) {
                return {
                    results: data
                }
            }
        }
    });

    $(".chosen_select_asset").select2({
        width: '100%',
        dropdownParent: $("#addPeminjamanDanaMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_asset',
            type: 'POST',
            dataType: 'JSON',
            data: function(params) {
                return {
                    searchTerm: params.term,
                    _token: '{{ csrf_token() }}'
                }
            },
            processResults: function(data) {
                return {
                    results: data
                }
            }
        }
    });

    // $('.autoNum').autoNumeric();

    // $(document).ready(function() {
    $(document).on('change', '.tipe_peminjaman', function() {
        var tipe_peminjaman = $(this).val();

        if (tipe_peminjaman !== '') {
            if (tipe_peminjaman == 1) {
                $('.table_alat').addClass('d-none');
            } else {
                $('.table_alat').removeClass('d-none');
            }
        } else {
            $('.table_alat').addClass('d-none');
        }
    });

    $(document).on('click', '.add_barang', function(e) {
        e.preventDefault();
        var id_peminjaman_dana = $('.id_peminjaman_dana').val();
        var nama_barang = $('.nama_barang').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('add_barang_peminjaman_dana') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id_peminjaman_dana': id_peminjaman_dana,
                'nama_barang': nama_barang
            },
            cache: false,
            dataType: 'json',
            beforeSend: function(result) {
                $('.add_barang').attr('disabled', true);
                $('.add_barang').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result) {
                if (result.valid == 1) {
                    $.notify("Selamat, barang sudah berhasil diinput !", "success");
                } else {
                    $.notify(
                        "Maaf, barang tidak berhasil diinput, silahkan coba lagi !",
                        "error");
                }
                $('.add_barang').attr('disabled', false);
                $('.add_barang').html('<i class="fa fa-plus"></i>');
                $('.list_barang').html(result.hasil);
            }
        });

    });

    $(document).on('click', '.del_barang', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var id_peminjaman_dana = $('.id_peminjaman_dana').val();

        $.ajax({
            type: 'DELETE',
            url: "{{ route('del_barang_peminjaman_dana') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id,
                'id_peminjaman': id_peminjaman_dana
            },
            cache: false,
            dataType: 'json',
            success: function(result) {
                if (result.valid == 1) {
                    $.notify("Selamat, barang sudah berhasil dihapus !",
                        "success");
                } else {
                    $.notify(
                        "Maaf, barang tidak berhasil di hapus, silahkan coba lagi !",
                        "error");
                }
                $('.list_barang').html(result.hasil);
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
                        url: "/save_peminjaman_dana",
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: 'JSON',
                        cache: false,
                        success: function(hasil) {
                            if (hasil.status == '1') {
                                Swal.fire(hasil.msg,
                                    "", "success").then((hasil1) => {
                                    $("#addPeminjamanDana").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            } else {
                                Swal.fire(hasil.msg,
                                    "", "error").then((hasil1) => {
                                    $("#addPeminjamanDana").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            }
                        },
                    });
                } else {
                    $.ajax({
                        url: "/save_edit_peminjaman_dana",
                        type: "PUT",
                        data: $(this).serialize(),
                        dataType: 'JSON',
                        cache: false,
                        success: function(hasil) {
                            if (hasil.status == '1') {
                                Swal.fire(hasil.msg,
                                    "", "success").then((hasil1) => {
                                    $("#addPeminjamanDana").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            } else {
                                Swal.fire(hasil.msg,
                                    "", "error").then((hasil1) => {
                                    $("#addPeminjamanDana").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            }
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
    // });
</script>
