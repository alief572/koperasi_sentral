@extends('dashboard.partial.main')

@section('content')
    <div class="col-md-12">
        <h4>Edit User Permission</h4>
    </div>
    <form action="" id="form_edit_user_permission">
        <div class="row">
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td>:</td>
                        <td>{{ $data_user->id }}</td>
                    </tr>
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
                            <th class="text-center">View</th>
                            <th class="text-center">Add</th>
                            <th class="text-center">Manage</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <thead>
                        @foreach ($list_menu as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td class="text-center">
                                    <input type="checkbox" name="check_view[]" value="{{ $item->id }}" id="">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="check_add[]" value="{{ $item->id }}" id="">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="check_manage[]" value="{{ $item->id }}" id="">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="check_delete[]" value="{{ $item->id }}" id="">
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
        <a href="/user_permission" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
        <button type="submit" class="btn btn-sm btn-primary" name="save"><i class="fa fa-save"></i> Save</button>
    </form>
@endsection

@section('javascript_section')
<script>
    $(document).ready(function(){
        $(document).on('submit', '#form_edit_user_permission', function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure ?',
                showCancelButton: true,
                showDenyButton: false,
                confirmButtonText: 'Save',
                icon: 'question'
            }).then((result) => {
                if(result.isConfirmed){
                    alert(1);
                }else{
                    alert(0);
                }
            });
        })
    })
</script>
@endsection
