@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ url($url.'/add') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-9">
                <label> Gói </label>
                <select id="package" class="form-control" name="package" required>
                    <option value="">Chọn</option>
                    <option value="15">15 ngày</option>
                    <option value="30">30 ngày</option>
                    <option value="180">6 tháng</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-9">
                <label> Thành tiền </label>
                <p id="total"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn" name="submit" value="Mua"></input>
                <a class="btn btn-default" href="{{ url('') }}">Thoát</a>
            </div>
        </div>

    </form>
    <script>
        $('#package').change(function () {
            var package = $(this).val();
            $.ajax({
                url: '{{url('getTotalBuyPackage')}}',
                type: 'post',
                data: {"package": package,  "_token": "{{ csrf_token() }}"},
                dataType: 'json',
                success: function (res) {
                    console.log(res.result);
                    $('#total').html((res.result));
                }
            });
        })

    </script>
@endsection
