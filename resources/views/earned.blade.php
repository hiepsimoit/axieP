@extends('layouts.index')
@section('title', 'SLP EARNED TABLE')
@section('titlePage', 'SLP EARNED TABLE')
@section('content')

<br>
<form id="formCV" class="form-inline" enctype="multipart/form-data" action="earnedPerDay" method="get">
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
<div id="result">
	<table class="table table-list table-condensed table-bordered table-hover tableLoa">
		<!-- <col width="50px">
		@foreach ($table as $key => $value)
		<col width="80px">
		@endforeach -->
		<thead>
			<tr style="">
				<th>Ngày</th>
				@foreach($accs as $var)
				<th>{{$var->acc_name}}</th>
				@endforeach
				<th>Tổng</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($table as $key => $value)
				<tr style="@if($key == 'Tổng') background-color:rgb(81, 104, 168); @endif">
					<td style="background-color:rgb(81, 104, 168); color: #fff; text-align: center;">
						{{$key}}
					</td>
					<?php $i=0; ?>
					@foreach($value as $data)

					<td style="background-color: @if($i < count($value) - 1 && $key != 'Tổng') @if($data == 0) #ff3030 @elseif($data > 0 && $data < 100) #fa8334 @elseif($data >= 100 && $data < $accs[$i]->pki && $accs[$i]->pki > 100) #e8ff69 @elseif($data > $accs[$i]->pki && $accs[$i]->pki > 100) #75ff70 @endif
					@elseif($i == count($value) - 1) rgb(81, 104, 168); color: #fff; @endif; @if($key == 'Tổng') color: #fff; @endif">
					{{  number_format($data, 0, ',', '.')}}
					</td>
					<?php $i++; ?>
					@endforeach
				</tr>
			@endforeach

		</tbody>
	</table>
</div>


<script>
	
</script>


@endsection