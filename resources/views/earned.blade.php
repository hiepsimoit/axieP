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
			<?php $accNum = count($accs); $totalVertical = []; $total = 0;?>
			<?php 
			for($i=1;$i<$numberDay+1;$i++){?>
				<tr>
					<td class="table-header" style="background-color: rgb(81, 104, 168); color: white;text-align: center;">{{$i}}</td>
					<?php 
					$totalHorizontal = 0;
					for($j=0;$j<$accNum;$j++){
						if(count($totalVertical) < $accNum)
							$totalVertical[] = 0;
						$earned = 0;
						$kpi = 0;
						foreach($table as $var){
							
							if($var->day == $i && $var->acc_id == $accs[$j]->id){
								$earned = $var->earned;
								$kpi = $accs[$j]->kpi;
								$totalVertical[$j] += $earned;
								$total += $earned;
							}
						}
						?>
						<td style="background-color: @if($earned == 0) #ff3030 @elseif($earned > 0 && $earned < 100) #fa8334 @elseif($earned >= 100 && $earned < $kpi && $kpi > 100) #e8ff69 @elseif($earned > $kpi && $kpi > 100) #75ff70 @endif; text-align: center;">
							{{$earned}}
						</td>
					<?php 
					$totalHorizontal += $earned;
					}
					?>
					<td class="table-header" style="background-color: rgb(81, 104, 168); color: white;text-align: center;">{{$totalHorizontal}}</td>

				</tr>
				<?php 
			} ?>
			
			<tr>
				<td class="table-header" style="background-color: rgb(81, 104, 168); color: white;text-align: center;">Tổng</td>
				<?php $count = 0; ?>
				@foreach($accs as $acc)
				<td class="table-header" style="background-color: rgb(81, 104, 168); color: white;text-align: center;"><?php echo $totalVertical[$count]; $count++; ?></td>
				@endforeach
				<td class="table-header" style="background-color: rgb(81, 104, 168); color: white;text-align: center;"><?php echo $total; ?></td>
			</tr>
		</tbody>
	</table>
</div>


<script>
	
</script>


@endsection