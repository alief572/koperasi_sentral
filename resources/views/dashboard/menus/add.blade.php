<div class="col-12">
    {{ csrf_field() }}
    <input type="hidden" name="type_post" class="type_post" value="POST">
    <table class="table">
        <tr>
            <td>ID Menus</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="id_menu" id="" class="form-control form-control-sm" readonly>
            </td>
            <td>Nama Menu</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="nama_menu" id="" class="form-control form-control-sm">
            </td>
        </tr>
        <tr>
            <td>Link</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="link_menu" id="" class="form-control form-control-sm">
            </td>
            <td>Parent Menu</td>
            <td class="text-center">:</td>
            <td>
                <select name="parent_menu" id="" class="form-control form-control-sm chosen-select">
                    <option value="">- Parent Menu -</option>
                    @foreach ($list_menu as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-center">:</td>
            <td>
                <select name="status" id="" class="form-control form-control-sm" required>
                    <option value="">- Status Menu -</option>
                    <option value="1">Active</option>
                    <option value="0">Non Active</option>
                </select>
            </td>
            <td>Icon</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="icon_menu" id="" class="form-control form-control-sm">
            </td>
        </tr>
        <tr>
            <td>Order</td>
            <td class="text-center">:</td>
            <td>
                <input type="number" name="order_menu" id="" class="form-control form-control-sm"   >
            </td>
            <td colspan="3"></td>
        </tr>
    </table>
</div>

<script>
    
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
                        url: "{{ route('save_menus') }}",
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
                                    // $("#addPeminjamanDana").modal('hide');
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
</script>