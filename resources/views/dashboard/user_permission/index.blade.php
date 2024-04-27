@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_user" data-toggle="modal" data-target="#addUser">
            <i class="fa fa-plus"></i>
            Tambah User
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($list_users as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="/user_permission/{{ $item->id }}/edit" class="btn btn-sm btn-primary text-light">
                            <i class="fa fa-universal-access"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <input type="hidden" name="type_form" class="type_form">
                    <div class="modal-body addUserMB">
                        <div class="form-group">
                            <label for="">Kategori User</label>
                            <select name="kategori_user" id="" class="form-control form-control-sm chosen-select"
                                required>
                                <option value="">- Kategori User -</option>
                                <option value="1">Admin</option>
                                <option value="2">Admin Peminjaman Asset</option>
                            </select>
                            @error('kategori_user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nama User</label>
                            <input type="text" name="nm_user" id="" class="form-control form-control-sm"
                                required>
                            @error('nm_user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control form-control-sm">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" id="" class="form-control form-control-sm"
                                required>
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="" class="form-control form-control-sm"
                                required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <form action="" method="post" id="edit_form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" class="id_user" value="">
                    <div class="modal-body editUserMB">
                        <div class="form-group">
                            <label for="">Kategori User</label>
                            <select name="kategori_user" id=""
                                class="form-control form-control-sm chosen_select_edit kategori_user" required>
                                <option value="">- Kategori User -</option>
                                <option value="1">Admin</option>
                                <option value="2">Admin Peminjaman Asset</option>
                            </select>
                            @error('kategori_user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nama User</label>
                            <input type="text" name="nm_user" id="" class="form-control form-control-sm nm_user"
                                required>
                            @error('nm_user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id=""
                                class="form-control form-control-sm email">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" id=""
                                class="form-control form-control-sm username" required>
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="" class="form-control form-control-sm">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript_section')
    <script>
        $(".chosen-select").select2({
            width: '100%',
            dropdownParent: $(".addUserMB")
        });
        $(".chosen_select_edit").select2({
            width: '100%',
            dropdownParent: $(".editUserMB")
        });
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
           $(".data-table").DataTable();
            $(document).on("click", ".add_user", function() {
                $(".modal-title").html("Tambah User");
                $("#data_form").prop("action", "/master_user");
                $(".type_form").val("POST");
            });

            $(document).on("click", ".edit_user", function() {
                $(".modal-title").html("Edit User");

                var id_user = $(this).data('id_user');

                $.ajax({
                    type: "GET",
                    url: "/get_data_user/" + id_user,
                    cache: false,
                    dataType: "JSON",
                    success: function(result) {
                        console.log(result);
                        $(".id_user").val(result.id);
                        $(".nm_user").val(result.name);
                        $(".email").val(result.email);
                        $(".username").val(result.username);
                        $(".kategori_user").val(result.kategori_user).trigger("change");
                    }
                });
            });

            $(document).on("submit", "#delete_form", function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin hapus user ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: "/master_user/" + id,
                            data: $(this).serialize(),
                            cache: false,
                            success: function(result) {
                               
                            }
                        });
                    }
                });
            });

            $(document).on("submit", "#data_form", function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: "warning",
                    title: "Anda sudah yakin ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "" + $(this).attr('action') + "",
                            type: "" + $(".type_form").val() + "",
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                Swal.fire(hasil.success,
                                    "", "success").then((hasil1) => {
                                    $("#addUser").modal('hide');
                                   
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
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on("submit", "#edit_form", function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: "warning",
                    title: "Anda sudah yakin ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/master_user/" + $(".id_user").val(),
                            type: "PUT",
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                Swal.fire(hasil.success,
                                    "", "success").then((hasil1) => {
                                    $("#editUser").modal('hide');
                                   
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
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });
        });
    </script>
@endsection
