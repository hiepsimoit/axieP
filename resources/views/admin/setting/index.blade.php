@extends('admin.layout.index')
@section('title', $title)
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
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                <div class="box-body">
                    <form action="{{ url('admin/'.$url) }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Tên website</label>
                            <input type="text" name="name" id="name" value="{{$data->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{$data->address}}" class="form-control">
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
