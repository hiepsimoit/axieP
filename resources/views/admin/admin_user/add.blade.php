@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">User Info</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('admin_user.store') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>User name</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" id="p" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" name="rePassword" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <button>Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
