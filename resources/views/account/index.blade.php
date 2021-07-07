@extends('layouts.index')
@section('title', $title)
@section('titlePage',$title)
@section('content')
    <form id="form-danhba" action="{{$url}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <label class="col-m-1">Người chơi</label>
            <div class="col-md-4">
                <input type="text" name="name"
                       value="{{ !empty($input['name']) ? $input['name']: '' }}"
                       class="form-control"
                       placeholder="">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button class="btn " type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <a class="btn  pull-left" href="{{ url($url."/add/") }}">Tạo mới </a>

    <div id="result">
        <?php if(!empty($data)) { ?>
        <table class="table table-list table-condensed table-bordered table-hover tableLoan">
            <thead>
            <tr>
                <td>STT</td>
                <td>Địa chỉ ví ronin</td>
                <td>Account</td>
                <td>Trạng thái</td>
                <td>Thao tác</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach  ($data as $item) { ?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php echo $item->ronin;?></td>
                <td><?php echo $item->acc_name;?></td>
                <td>
                    <?php switch ($item->status){
                        case  1 :$status  = 'Đang hoạt động';break;
                        case  -1 :$status  = 'Đã xóa';break;
                        default :$status = '';break;
                    } echo $status;?>

                </td>


                <td>
                    <a class="btn btn-default btn-success" href="{{ url($url."/edit/{$item->id}") }}">Chi tiết </a>

                    <a class="confirm btn btn-default btn-danger" href="{{ url($url."/delete/{$item->id}") }}">Hủy</a><br/>

                </td>

            </tr>
            <?php } ?>
            </tbody>
        </table>
        {{ $data->appends(request()->input())->links() }}

        <?php } ?>
    </div>
    <script>

        $('.confirm').click(function(){
            return confirm('Bạn có xác nhận xóa hay ko?');
        });
    </script>
@endsection
