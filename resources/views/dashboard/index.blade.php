@extends('dashboard.partial.main')

@section('content')
    @if (session('permission_error'))
        <div class="alert alert-danger">
            <i class="fa fa-close"></i> {{ session('permission_error') }}
        </div>
    @endif
@endsection