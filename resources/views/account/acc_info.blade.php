@extends('layouts.index')
@section('title', 'Thống kê accounts')
@section('titlePage', 'Thống kê accounts')
@section('content')

<table class="table select_table my-table table-bordered">
	<!-- <col width="50px"> -->
	
	<thead>
		<tr style="background: #af1c3f; color: white;">
			<th colspan="1" rowspan="2">STT</th>
			<th colspan="1" rowspan="2">Người chơi</th>
			<th colspan="1" rowspan="2">Account</th>
			<th colspan="4" rowspan="1">SLP</th>
			<th colspan="1" rowspan="2">Claim lần cuối</th>
			<th colspan="1" rowspan="2">Claim lần kế</th>
			<th colspan="1" rowspan="2">Rank</th>

		</tr>
		<tr style="background: #af1c3f; color: white;">
			<th colspan="1" rowspan="1">Trung bình</th>
			<th colspan="1" rowspan="1">Đã claim</th>
			<th colspan="1" rowspan="1">Chưa claim</th>
			<th colspan="1" rowspan="1">Tổng</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; ?>
		@foreach ($table as $key => $value)
			<tr>
				<td>
					<?php echo $i;$i++; ?>
				</td>
				<td>{{$value[0]}}</td>
				<td>{{$value[1]}}</td>
				<td>{{$value[2]}}</td>
				<td>{{$value[3]}}</td>
				<td>{{$value[4]}}</td>
				<td>{{$value[5]}}</td>
				<td>{{$value[6]}}</td>
				<td>{{$value[7]}}</td>
				<td>{{$value[8]}}</td>
			</tr>
		@endforeach

	</tbody>
</table>

@endsection