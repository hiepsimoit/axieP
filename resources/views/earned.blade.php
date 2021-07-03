@extends('layouts.index')
@section('title', 'SLP EARNED TABLE')
@section('titlePage', 'SLP EARNED TABLE')
@section('content')

<br>
<form id="formCV" class="form-inline" enctype="multipart/form-data" action="earn" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
		<div class="col-md-2">Chọn tháng:</div>
		<div class="col-md-2">
			<input type="text" id="choose_month" name="choose_month" class="form-control dtMonthPicker" value="{{date('m/Y')}}">
		</div>
		
	</div>
</form>

<table class="table select_table my-table table-bordered">
	<!-- <col width="50px"> -->
	
	<thead>
		<tr style="background: #af1c3f; color: white;">
			<th>Ngày</th>
			@foreach($accs as $var)
			<th>Acc {{$var->id}}</th>
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

<script>
	
</script>


@endsection