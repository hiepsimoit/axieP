@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ $data->id }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-9">
                <label> Tên </label>
                <input type="text" class="form-control" maxlength="255"  name="name" value="{{ $data->name }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Số tài khoản </label>
                <input type="text" class="form-control" maxlength="255"  name="bank_acc"  value="{{ $data->bank_acc  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Ngân hàng </label>
                <input type="text" class="form-control" maxlength="255"  name="bank_name"  value="{{ $data->bank_name  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Lương </label>
                <input type="text" class="form-control" maxlength="255"  onkeyup="FormatNumber(this)"  name="salary"  value="{{ number_format($data->salary, 0, ',', '.') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn"   name="submit" value="Sửa" >
                <a class="btn btn-default" href="{{ url('') }}">Thoát</a>
            </div>
        </div>

    </form>
    <script>

        function FormatNumber(obj) {
            var strvalue;

            if (eval(obj))
                strvalue = eval(obj).value;
            else
                strvalue = obj;
            var num;
            num = strvalue.toString().replace(/\$|\./g, '');
            if (isNaN(num))
                num = "";
            sign = (num == (num = Math.abs(num)));

            num = Math.floor(num * 100 + 0.50000000001);
            num = Math.floor(num / 100).toString();
            if (num == 0) {
                num = '';
            }

            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
            //return (((sign)?'':'-') + num);
            eval(obj).value = (((sign) ? '' : '-') + num);
        }
    </script>
@endsection