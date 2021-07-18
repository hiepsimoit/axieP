@extends('layouts.index')
@section('title', 'Bảng lương, thưởng')
@section('titlePage', 'Bảng lương, thưởng')
@section('content')

<form id="formCV" class="form-inline" enctype="multipart/form-data" action="rewards" method="get">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
		<div class="col-md-2">Chọn tháng:</div>
		<div class="col-md-2">
			<input type="text" id="choose_month" name="choose_month" class="form-control dtMonthPicker" value="@if($choose_month) {{$choose_month}} @else {{date('m/Y')}}@endif">
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-success" id="button_search" name="button_search">Search</button>
		</div>
	</div>
	
</form>

<table class="table select_table my-table table-bordered">
	<col width="125px">
	<col width="125px">
	<col width="100px">
	<col width="100px">
	<col width="100px">
	<col width="100px">
	<col width="100px">
	<col width="250px">
	<col width="50px">
	
	<thead>
		<tr style="">
			<th >Người chơi</th>
			<th >Account</th>
			<th >SLP/ngày</th>
			<th >Lương</th>
			<th >Tổng thưởng</th>
			<th >Giá trị</th>
			<th >Thưởng/Phạt</th>
			<th >Lý do</th>
			<th >Cập nhật</th>
		</tr>
		
	</thead>
	<tbody>
		<?php $totalPayable = 0;?>
		@foreach($staffs as $staff)
			<?php $totalSalary = 0; ?>
			<tr style="background-color: #8cd9ff;">
				<td rowspan="1" colspan="1">
					{{$staff->name}}
				</td>
				<td rowspan="1" colspan="8">
					STK: {{$staff->bank_acc}} - Ngân hàng: {{$staff->bank_name}}
				</td>
			</tr>
			@foreach($accounts as $acc)
				@if($acc->staff_id == $staff->id)
				<?php $totalSalary += $staff->salary; ?>
				<tr style="background-color: #bde9ff;">
					<td></td>
					<td>{{$acc->acc_name}}</td>
					<td>{{$acc->everage}}</td>
					<td>{{number_format($staff->salary)}}</td>
					<td id="total_reward_{{$acc->id}}">
						<?php $totalReward = 0; ?>
						@foreach($rewards as $rw)
						@if($rw->acc_id == $acc->id)
							<?php 
							if($rw->type == 1)
								$totalReward += $rw->value; 
							else
								$totalReward -= $rw->value; 
							?>
						@endif
						@endforeach
						{{number_format($totalReward)}}
					</td>
					<td>
						<input type="text" name="text_reward_{{$acc->id}}" id="text_reward_{{$acc->id}}" class="form-control" onkeyup="FormatNumber(this)">
					</td>
					<td>
						<select class="form-control" id="select_type_{{$acc->id}}" name="select_type_{{$acc->id}}">
							<option value="1">Thưởng</option>
							<option value="0">Phạt</option>
						</select>
					</td>
					<td>
						<input type="text" name="text_lydo_{{$acc->id}}" id="text_lydo_{{$acc->id}}" class="form-control" list="list_lydo">
						<datalist id="list_lydo">
							<option>Thưởng hoàn thành nhiệm vụ ngày trong thời gian lag</option>
							<option>Thưởng thành tích tốt</option>
							<option>Thưởng đột xuất</option>
							<option>Phạt ko hoàn thành nhiệm vụ</option>
						</datalist>
					</td>
					<td>
						<button type="button" class="btn btn_update_reward form-control" id="btn_update_{{$acc->id}}">Cập nhật</button>
					</td>
				</tr>
				
				@endif
			@endforeach
			<tr >
				<td></td>
				<td colspan="3" style="background-color: #ffb18a;" id="total_ncome_{{$staff->id}}">
					Tổng thu nhập: {{ number_format ($totalSalary + $totalReward)}}
					<?php $totalPayable +=  ($totalSalary + $totalReward);?>
				</td>

			</tr>
		@endforeach
		<tr>
			<td colspan ="9" style="background-color: #ff8a8a; text-align: center;">
				Tổng lương phải trả: {{number_format($totalPayable)}} VND.
			</td>

		</tr>
	</tbody>
</table>
<script type="text/javascript">
	function FormatNumber(obj) {
        var strvalue;

        if (eval(obj))
            strvalue = eval(obj).value;
        else
            strvalue = obj;
        var num;
        num = strvalue.toString().replace(/\$|\,/g, '');
        if (isNaN(num))
            num = "";
        sign = (num == (num = Math.abs(num)));

        num = Math.floor(num * 100 + 0.50000000001);
        num = Math.floor(num / 100).toString();
        if (num == 0) {
            num = '';
        }

        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
        //return (((sign)?'':'-') + num);
        eval(obj).value = (((sign) ? '' : '-') + num);
    }

    $(".btn_update_reward").click(function(){
    	var btn_id = $(this).attr('id');
    	var acc_id = btn_id.substring(11, btn_id.length);
    	// console.log(acc_id);
    	var reward = $("#text_reward_"+acc_id).val();
    	var reward_type = $("#select_type_"+acc_id).val();
    	var lydo = $("#text_lydo_"+acc_id).val();
    	var choose_month = $('#choose_month').val();

    	$.ajax({
            url: '{{url('updateReward')}}',
            type: 'post',
            data: {"acc_id": acc_id, "reward":reward, "reward_type":reward_type, "lydo":lydo, "choose_month":choose_month, "_token": "{{ csrf_token() }}"},
            dataType: 'json',
            success: function (res) {
            	$('#total_reward_'+res.acc_id).html(FormatNumber2(res.totalReward));
            	$('#total_income_'+res.staff_id).html('Tổng thu nhập: '+FormatNumber2(res.totalIncome));
            	alert('Cập nhật thành công!');
            }
        });
    });

    function FormatNumber2(strvalue) {
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
            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
        return (((sign)?'':'-') + num);
        // eval(obj).value = (((sign) ? '' : '-') + num);
    }
</script>
@endsection