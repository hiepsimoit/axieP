
@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ url('changePass') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        <div class="form-group row">
            <label for="oldPassword" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu cũ') }}</label>

            <div class="col-md-6">
                <input id="oldPassword" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="oldPassword" required>

            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
