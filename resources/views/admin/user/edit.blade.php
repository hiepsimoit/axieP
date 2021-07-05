@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->

    <form class="form-horizontal" action="admin/user/edit" method="post">
        {{ csrf_field() }}
        <div class="box-body">
            @if($errors->any())
                @foreach($errors->all() as $err)
                    {{ $err }} <br>
                @endforeach
            @endif
            @if(session('message'))
                <div class="alert">
                    {{ session('message') }}
                </div>
            @endif
            <div class="form-group">
                <label class="col-md-2">User</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" disabled name="username" value="{{ $getInfo->username }}"
                           placeholder=""></div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <p class="note"> Mật khẩu độ dài tối thiểu 8 kí tự, có kí (A – Z),(a – z),(0 – 9),(!, $, #, or
                        %) </p>
                </div>
                <label class="col-md-2">Mật khẩu mới</label>
                <div class="col-md-10">
                    <input class="form-control" type="password" name="password" value=""
                           placeholder=""></div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Nhập lại mật khẩu mới</label>
                <div class="col-md-10">
                    <input class="form-control" type="password" name="re_password" value=""
                           placeholder=""></div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
                </div>
            </div>
        </div>

    </form>

    <!-- /.content -->
@endsection
