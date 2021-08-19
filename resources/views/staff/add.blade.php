@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ url($url.'/add') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-12">
                <label> Tên </label>
                <input type="text" class="form-control" maxlength="255"  name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Số tài khoản </label>
                <input type="text" class="form-control" maxlength="255"  name="bank_acc"  value="{{ old('bank_acc')  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Ngân hàng </label>
                <input type="text" class="form-control" maxlength="255"  name="bank_name"  value="{{ old('bank_name')  }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label> Kiểu trả lương </label>
                <select class="form-control" id="salary_type" name="salary_type">
                    <option value="1">Lương cứng theo VND</option>
                    <option value="2">Chia sẻ % SLP</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label> Lương </label>
                <input type="text" class="form-control" maxlength="255"  onkeyup="FormatNumber(this)" id="salary"  name="salary"  value="{{ old('salary') }}" placeholder="VND">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <input type="submit" class="btn"   name="submit" value="Tạo" ></input>
                <a class="btn btn-default" href="{{ url('') }}">Thoát</a>
            </div>
        </div>

    </form>
    <script>

        $('#salary_type').change(function(){
            if($(this).val() == 1)
                $('#salary').attr('placeholder', 'VND');
            else
                $('#salary').attr('placeholder', '%');
        });
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
