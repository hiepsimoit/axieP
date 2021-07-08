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
                <label> Thành tiền <p id ="total"></p> </label>

            </div>
        </div>
        <div class="row form-group">
            <h4>Chọn tài khoản mua</h4>
            <table id="tableResult" class="table table-list table-condensed table-bordered table-hover tableLoan">
                <thead>
                <tr>
                    <td>STT</td>
                    <td>Địa chỉ ví ronin</td>
                    <td>Account</td>
                    <td>Chọn mua <input id="all" type="checkbox"></td>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($dataAccount)) {
                    $i =1;
                foreach  ($dataAccount as $item) { ?>

                <tr>
                    <td><?php echo $i; $i++;?></td>
                    <td><?php echo $item->ronin;?></td>
                    <td><?php echo $item->acc_name;?></td>
                    <td class="text-center">
                        <div class="chkbox">
                            <input class="select_status" type="hidden" name="select_status[]"/>
                            <input type="checkbox"/>
                            <input class="send" type="hidden" name="send[]"
                                   value="<?php echo $item->id  ?>">
                            <br/></div>
                    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table>
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
            callTotal();
        });
        function callTotal(){
            var package = $('#package').val();
            var total = 0;
            $('#tableResult > tbody  > tr').each(function(index, tr) {
                var result = $(this).find('.select_status').val();
                if(result != ''){
                    total +=  parseInt($(this).find('.select_status').val());
                }
            });
            $.ajax({
                url: '{{url('getTotalBuyPackage')}}',
                type: 'post',
                data: {"package": package,"total":total,  "_token": "{{ csrf_token() }}"},
                dataType: 'json',
                success: function (res) {
                    $('#total').html((res.result));
                }
            });
        }
        $('.table-list').find('.chkbox').on('click', 'input[type=checkbox]', function () {
            var curr_stt = this.checked;
            var curr_value = (curr_stt) ? 1 : 0;
            $(this).parents('.chkbox').find('input[name="select_status[]"]').val(curr_value);
            var all_check = true;
            $('.chkbox').find('input[type=checkbox]').each(function () {
                var stt = this.checked;
                if (!stt) {
                    all_check = false;
                }
            });
            $('#all').prop('checked', all_check);
            callTotal();
        });

        $('.table-list').on('click', '#all', function () {
            var stt = this.checked;
            var stt_value = (stt) ? 1 : 0;
            $('.table-list .chkbox').each(function () {
                $(this).find('input[type=checkbox]').prop('checked', stt);
                $(this).find('input[name="select_status[]"]').val(stt_value);
            });
            callTotal();
        });
    </script>
@endsection
