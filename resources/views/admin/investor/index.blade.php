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
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Link</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Paid</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <tbody>
        <?php  $i = 1; ?>
        @foreach ($data as $item)
            <tr>
                <td> {{ $i }} </td>
                <td> {{ $item->name }} </td>
                <td> {{ $item->link }} </td>
                <td> {{ $item->email }} </td>
                <td> {{ $item->phone }} </td>
                <td>
                    <?php
                    switch ($item->paid) {
                        case -1:
                            $paid = 'chưa trả';
                            break;
                        case 1:
                            $paid = 'đã trả';
                            break;
                        default:
                            $paid = $item->paid;
                            break;
                    }
                    echo $paid;
                    ?>

                </td>
                <td>
                    <?php
                    switch ($item->status) {
                        case 0:
                            $status = 'chưa active';
                            break;
                        case 1:
                            $status = 'đã active';
                            break;
                        default:
                            $status = $item->status;
                            break;
                    }
                    echo $status;
                    ?>

                </td>
                <td>
                    <?php if($item->paid == -1){ ?>
                    <a href="{{ url('admin/investor/activePaid/'.$item->id )}}" title="Active Paid"
                       class="btn btn-primary pull-left" style="margin-right: 10px"><span
                                class="fa fa-edit "></span></a>
                    <?php } ?>
                    <?php if($item->status == 1){ ?>
                    <a href="{{ url('admin/investor/deletePaid/'.$item->id )}}" title="Delete Paid"
                       class="btn btn-primary pull-left" style="margin-right: 10px"><span class="fa fa-remove "></span></a>
                    <?php } ?>
                    <?php if($item->status == -1){ ?>
                    <a href="{{ url('admin/investor/active/'.$item->id )}}" title="Mở khóa"
                       class="btn btn-primary pull-left" style="margin-right: 10px"><span
                                class="fa fa-edit "></span></a>
                    <?php } ?>
                    <?php if($item->status == 1){ ?>
                    <a href="{{ url('admin/investor/delete/'.$item->id )}}" title="Khóa"
                       class="btn btn-primary pull-left" style="margin-right: 10px"><span class="fa fa-remove "></span></a>
                    <?php } ?>
                </td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>

    <!-- /.content -->
@endsection
