@extends('layouts.index')
@section('title', $title)
@section('titlePage',$title)
@section('content')
    <form id="form-danhba" action="{{$url}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <label class="col-label">Mgười chơi</label>
            <div class="col-md-4">
                <input type="text" name="name"
                       value="{{ !empty($input['name']) ? $input['name']: '' }}"
                       class="form-control"
                       placeholder="">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button class="btn btn-default btn-danger btn-search-cv" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <a class="btn btn-danger pull-left" href="{{ url($url."/add/") }}">Tạo mới </a>

    <div id="result">
        <?php if(!empty($data)) { ?>
        <table class="table table-list table-condensed table-bordered table-hover tableLoan">
            <thead>
            <tr>
                <td>STT</td>
                <td>Gói</td>
                <td>Số lượng tài khoản</td>
                <td>Thành tiền</td>
                <td>Mã chuyển tiền</td>
                <td>Ngày mua</td>
                <td>Trạng thái</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach  ($data as $item) { ?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php
                    switch ($item->package){
                        case 15: $pac = '15 ngày';break;
                        case 30: $pac = '30 ngày';break;
                        case 180: $pac = '6 tháng';break;
                        default: $pac = $item->package;break;
                    }
                    echo $pac;

                ?></td>
                <td><?php echo $item->number_acc;?></td>

                <td><?php echo  number_format($item->total_price, 0, ',', '.') .' USD';?></td>
                <td><?php echo $item->code;?></td>
                <td class="text-center">
                    <?php echo date('d/m/Y H:i:s', strtotime($item->created_at));?>
                </td>
                <td>
                    <?php switch ($item->status){
                        case  1 :$status  = 'Đã phê duyệt';break;
                        case  0 :$status  = 'Chờ phê duyệt';break;
                        default :$status = '';break;
                    } echo $status;?>

                </td>

            </tr>
            <?php $i++; } ?>
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
