@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->

    <h1>Danh sách User</h1>

    <table class="table table-border">
        <tr>
            <th>STT</th>
            <th>Username</th>
            <th>Họ tên</th>
            <th>Chi nhánh</th>
            <th>Phòng giao dịch</th>

            <th>Email</th>
            <th>Mã nhân viên</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        <tbody>
        <?php  $i = 1; ?>
        @foreach ($data as $list)
            <tr>
                <td> {{ $i }} </td>
                <td> {{ $list->username }} </td>
                <td> {{ $list->fullname }} </td>
                <td>{{ $list->branch_name }}  </td>
                <td>{{ $list->department_name }}  </td>

                <td> {{ $list->email }} </td>
                <td> {{ $list->manv }} </td>
                <td>{{ $list->phone }} </td>
                <td>@if($list->status == 1)
                        Đang hoạt động
                    @elseif ($list->status == -1)
                        Đã xóa
                    @endif
                </td>

                <td>
                    <?php if($list->admin != 1) { ?>
                    <a href="{{ url("admin/user/edit/{$list->id}") }}">Sửa</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if($list->admin != 1) { ?>
                    <a href="{{ url("admin/user/delete/{$list->id}") }}">Xóa</a>
                    <?php } ?>
                </td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    <!-- /.content -->
@endsection
