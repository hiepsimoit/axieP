@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form method="Post" action="{{ url('admin/'.$url)  }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <label class="col-md-2">Tài khoản</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="{{ isset($input['email']) ? $input['email'] : '' }}"
                       name="email">
            </div>

        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <button class="btn btn-default" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <table class="table table-border">

        <thead>
        <tr>
            <td>STT</td>
            <td>Gói</td>
            <td>Số lượng tài khoản</td>
            <td>Thành tiền</td>
            <td>Mã chuyển tiền</td>
            <td>Ngày mua</td>
            <td>Trạng thái</td>
            <td>Người mua </td>

            <td>Thao tác</td>
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
            <td>
                <?php  echo $item->email;?>
            </td>
            <td>
            <?php if($item->status == 0){ ?>
            <a href="{{ url('admin/buy_package/acitve/'.$item->id )}}" title="Cập nhật"
               class="btn btn-primary pull-left" style="margin-right: 10px"><span
                        class="fa fa-edit "></span></a>
            <?php } ?>
            </td>
        </tr>
        <?php $i++; } ?>
        </tbody>
    </table>

    <!-- /.content -->
@endsection
