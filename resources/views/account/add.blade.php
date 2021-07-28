@extends('layouts.index')
@section('title', $title)
@section('titlePage', $title)
@section('content')
    <form id="formCV" enctype="multipart/form-data" action="{{ url($url.'/add') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-12">
                <label> Người chơi</label>
                <select class="form-control" name="staff_id">
                    <option value="">Chọn</option>
                    <?php  if(!empty($dataStaff)){foreach ($dataStaff as $item) {?>
                    <option <?php if (old('staff_id') == $item->id) {
                        echo 'selected';
                    }?>  value="<?php echo $item->id; ?>"><?php echo $item->name ?></option>
                    <?php } }?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <label> Địa chỉ ví Ronin </label>
                <input type="text" class="form-control" maxlength="100"  name="ronin" value="{{ old('ronin') }}">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-9">
                <label> Account name </label>
                <input type="text" class="form-control" maxlength="45"  name="acc_name" value="{{ old('acc_name') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-9">
                <label> KPI </label>
                <input type="text" class="form-control" maxlength="45"  name="kpi" value="{{ old('kpi') }}">
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn"   name="submit" value="Tạo" ></input>
                <a class="btn btn-default" href="{{ url('') }}">Thoát</a>
            </div>
        </div>

    </form>

@endsection
