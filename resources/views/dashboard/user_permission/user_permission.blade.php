@extends('dashboard.partial.main')

@section('content')
    <div class="col-md-12">
        <h4>Edit User Permission</h4>
    </div>
    <form action="" id="form_edit_user_permission">
        {{ csrf_field() }}
        <input type="hidden" name="id_user" id="id_user" value="{{ $data_user->username }}">
        <div class="row">
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>{{ $data_user->username }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $data_user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $data_user->email }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Menu</th>
                            <th class="text-center">
                                <input type="checkbox" name="" id="check_all_box">
                            </th>
                            <th class="text-center">View</th>
                            <th class="text-center">Add</th>
                            <th class="text-center">Manage</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_menu as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->title }}</td>
                                <td class="text-center">
                                    <input type="checkbox" name="" id="" class="check_all"
                                        data-id="{{ $item->id }}">
                                </td>
                                @foreach ($list_permission as $permission)
                                    @if ($item->title == $permission->nm_menu)
                                        @if ($permission->ket == 'View')
                                            @php
                                                $checked = '';
                                            @endphp
                                            @for ($i = 0; $i < $count_user_permission; $i++)
                                                @if (isset($user_permission[$i]->id_permission) && $permission->id == $user_permission[$i]->id_permission)
                                                    @php
                                                        $checked = 'checked';
                                                    @endphp
                                                @endif
                                            @endfor
                                            <td class="text-center">
                                                <input type="checkbox" class="check_view_{{ $item->id }}"
                                                    name="check_view[]" value="{{ $permission->id }}" id=""
                                                    {{ $checked }}>
                                            </td>
                                        @endif
                                        @if ($item->link !== '#')
                                            @if ($permission->ket == 'Add')
                                                @php
                                                    $checked = '';
                                                @endphp
                                                @for ($i = 0; $i < $count_user_permission; $i++)
                                                    @if (isset($user_permission[$i]->id_permission) && $permission->id == $user_permission[$i]->id_permission)
                                                        @php
                                                            $checked = 'checked';
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <td class="text-center">
                                                    <input type="checkbox" class="check_add_{{ $item->id }}"
                                                        name="check_add[]" value="{{ $permission->id }}" id=""
                                                        {{ $checked }}>
                                                </td>
                                            @endif
                                            @if ($permission->ket == 'Manage')
                                                @php
                                                    $checked = '';
                                                @endphp
                                                @for ($i = 0; $i < $count_user_permission; $i++)
                                                    @if (isset($user_permission[$i]->id_permission) && $permission->id == $user_permission[$i]->id_permission)
                                                        @php
                                                            $checked = 'checked';
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <td class="text-center">
                                                    <input type="checkbox" class="check_manage_{{ $item->id }}"
                                                        name="check_manage[]" value="{{ $permission->id }}" id=""
                                                        {{ $checked }}>
                                                </td>
                                            @endif
                                            @if ($permission->ket == 'Delete')
                                                @php
                                                    $checked = '';
                                                @endphp
                                                @for ($i = 0; $i < $count_user_permission; $i++)
                                                    @if (isset($user_permission[$i]->id_permission) && $permission->id == $user_permission[$i]->id_permission)
                                                        @php
                                                            $checked = 'checked';
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <td class="text-center">
                                                    <input type="checkbox" class="check_delete_{{ $item->id }}"
                                                        name="check_delete[]" value="{{ $permission->id }}" id=""
                                                        {{ $checked }}>
                                                </td>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="/user_permission" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
        <button type="submit" class="btn btn-sm btn-primary" name="save"><i class="fa fa-save"></i> Save</button>
    </form>
@endsection

@section('javascript_section')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#form_edit_user_permission', function(e) {
                e.preventDefault();
                var id_user = $('#id_user').val();

                Swal.fire({
                    title: 'Are you sure ?',
                    showCancelButton: true,
                    showDenyButton: false,
                    confirmButtonText: 'Save',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $(this).serialize();
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('edit_user_permission') }}',
                            data: formData,
                            cache: false,
                            dataType: 'json',
                            success: function(result) {
                                if (result.status == '1') {
                                    Swal.fire({
                                        title: 'Success !',
                                        text: 'User Permission has been saved !',
                                        icon: 'success'
                                    }).then((hasil) => {
                                        window.location.href =
                                            '/user_permission';
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error !',
                                        text: 'Please try again later !',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(result) {
                                Swal.fire({
                                    title: 'Error !',
                                    text: 'Please try again later !',
                                    icon: 'error'
                                });
                            }
                        })
                    }
                });
            });

            $(document).on('click', '#check_all_box', function() {
                if (this.checked) {
                    $('input:checkbox').prop('checked', true);
                } else {
                    $('input:checkbox').prop('checked', false);
                }
            });

            $(document).on('click', '.check_all', function() {
                var id = $(this).data('id');
                if (this.checked) {
                    $('.check_view_' + id).prop('checked', true);
                    $('.check_manage_' + id).prop('checked', true);
                    $('.check_add_' + id).prop('checked', true);
                    $('.check_delete_' + id).prop('checked', true);
                } else {
                    $('.check_view_' + id).prop('checked', false);
                    $('.check_manage_' + id).prop('checked', false);
                    $('.check_add_' + id).prop('checked', false);
                    $('.check_delete_' + id).prop('checked', false);
                }
            });
        })
    </script>
@endsection
