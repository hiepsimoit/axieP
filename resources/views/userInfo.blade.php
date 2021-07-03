
@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ url('userInfo') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-9">
                <label> Tên </label>
                <input type="text" class="form-control" maxlength="100"  name="name" value="{{ $data->name }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Link </label>
                <input type="text" class="form-control" maxlength="45"  name="link"  value="{{ $data->link  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Email </label>
                <input type="email"  disabled class="form-control" maxlength="255"  name="email"  value="{{ $data->email  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Số điện thoại </label>
                <input type="text" class="form-control" maxlength="255"   name="phone"  value="{{ $data->phone }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('changePass') }}">Đổi mật khẩu</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn"   name="submit" value="Cập nhật" ></input>
                <a class="btn btn-default" href="{{ url('') }}">Thoát</a>
            </div>
        </div>

    </form>

@endsection
