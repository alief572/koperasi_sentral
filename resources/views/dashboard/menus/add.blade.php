<div class="col-12">
    {{ csrf_field() }}
    <input type="hidden" name="type_post" class="type_post" value="{{ (isset($data_menus)) ? 'PUT' : 'POST' }}">
    <input type="hidden" name="id_menus" value="{{ (isset($data_menus)) ? $data_menus->id : null }}">
    <table class="table">
        <tr>
            <td>ID Menus</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="id_menu" id="" class="form-control form-control-sm" value="{{ (isset($data_menus)) ? $data_menus->id : null }}" readonly>
            </td>
            <td>Nama Menu</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="nama_menu" id="" class="form-control form-control-sm" value="{{ (isset($data_menus)) ? $data_menus->title : null }}">
            </td>
        </tr>
        <tr>
            <td>Link</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="link_menu" id="" class="form-control form-control-sm" value="{{ (isset($data_menus)) ? $data_menus->link : null }}">
            </td>
            <td>Parent Menu</td>
            <td class="text-center">:</td>
            <td>
                <select name="parent_menu" id="" class="form-control form-control-sm chosen-select">
                    <option value="">- Parent Menu -</option>
                    @foreach ($list_menu as $menu)
                        <option value="{{ $menu->id }}" {{ (isset($data_menus) && $data_menus->parent_id == $menu->id) ? 'selected' : null }}>{{ $menu->title }}</option>
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
                    <option value="1" {{ (isset($data_menus) && $data_menus->status == '1') ? 'selected' : null }}>Active</option>
                    <option value="0" {{ (isset($data_menus) && $data_menus->status == '0') ? 'selected' : null }}>Non Active</option>
                </select>
            </td>
            <td>Icon</td>
            <td class="text-center">:</td>
            <td>
                <input type="text" name="icon_menu" id="" class="form-control form-control-sm" value="{{ (isset($data_menus)) ? $data_menus->icon : null }}">
            </td>
        </tr>
        <tr>
            <td>Order</td>
            <td class="text-center">:</td>
            <td>
                <input type="number" name="order_menu" id="" class="form-control form-control-sm"  value="{{ (isset($data_menus)) ? $data_menus->order : null }}">
            </td>
            @if (isset($data_menus))
                <td>Permission</td>
                <td class="text-center">:</td>
                <td>
                    <select name="permission_id" id="" class="form-control form-control-sm chosen-select">
                        <option value="">- Pilih Permission -</option>
                        @foreach ($list_permission as $permission_item)
                            <option value="{{ $permission_item->id }}" {{ ($permission_item->id == $data_menus->permission_id) ? 'selected' : null }}>{{ $permission_item->nm_permission }}</option>
                        @endforeach
                    </select>
                </td>
            @else
                <td colspan="3"></td>
            @endif
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
                                    $("#addMenus").modal('hide');

                                    // alert(hasil.nama_menu);

                                    $.ajax({
                                        type: "PUT",
                                        url: "{{ route('add_auto_permission') }}",
                                        cache: false,
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            nama_menu: hasil.nama_menu
                                        },
                                        cache: false
                                    });

                                    dataTable.ajax.reload();
                                });
                            } else {
                                Swal.fire(hasil.msg,
                                    "", "error").then((hasil1) => {
                                    // $("#addMenus").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            }
                        },
                    });
                } else {
                    $.ajax({
                        url: "{{ route('edit_menus') }}",
                        type: "PUT",
                        data: $(this).serialize(),
                        dataType: 'JSON',
                        cache: false,
                        success: function(hasil) {
                            if (hasil.status == '1') {
                                Swal.fire(hasil.msg,
                                    "", "success").then((hasil1) => {
                                    $("#addMenus").modal('hide');

                                    dataTable.ajax.reload();
                                });
                            } else {
                                Swal.fire(hasil.msg,
                                    "", "error").then((hasil1) => {
                                    // $("#addMenus").modal('hide');
                                    dataTable.ajax.reload();
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