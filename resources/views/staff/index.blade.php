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
                <td>Tên</td>
                <td>Số tài khoản</td>
                <td>Ngân hàng</td>
                <td>Lương</td>
                <td>Trạng thái</td>
                <td>Thao tác</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach  ($data as $item) { ?>
            <tr>
                <td><?php echo $i; $i++;?></td>
                <td><?php echo $item->name;?></td>
                <td><?php echo $item->bank_acc;?></td>
                <td><?php echo $item->bank_name;?></td>
                <td><?php echo  number_format($item->salary, 0, ',', '.') ;?></td>
                <td>
                    <?php switch ($item->status){
                        case  1 :$status  = 'Đang hoạt động';break;
                        case  -1 :$status  = 'Đã xóa';break;
                        default :$status = '';break;
                    } echo $status;?>

                </td>
                <td>
                    <a class="btn btn-default btn-success" href="{{ url($url."/edit/{$item->id}") }}">Chi tiết </a>
                    <?php if($item->status ==1){ ?>
                    <a class="confirm btn btn-default btn-danger" href="{{ url($url."/delete/{$item->id}") }}">Hủy</a><br/>
                  <?php  } else { ?>
                    <a class="confirm btn btn-default btn-danger" href="{{ url($url."/active/{$item->id}") }}">Khôi phục</a><br/>
                    <?php } ?>
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
