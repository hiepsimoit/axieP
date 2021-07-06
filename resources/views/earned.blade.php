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
<div style="overflow-x:auto;">
	<table class="my-table">
		<thead>
			<tr style="background: #af1c3f; color: white;">
				<th>Ngày</th>
				@foreach($accs as $var)
				<th>{{$var->acc_name}}</th>
				@endforeach
				<th>Tổng</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($table as $key => $value)
				<tr style="@if($key == 'Tổng') background-color: #ffd52b; font-weight: bold; @endif">
					<td>
						{{$key}}
					</td>
					@foreach($value as $data)
					<td>
					{{$data}}
					</td>
					@endforeach
				</tr>
			@endforeach

		</tbody>
	</table>
</div>


<script>
	
</script>


@endsection