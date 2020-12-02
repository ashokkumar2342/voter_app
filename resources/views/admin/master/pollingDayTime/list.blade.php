<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Block</th>
			<th>Polling Day Time (English)</th>
			<th>Polling Day Time (Local Language)</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($PollingDayTimes as $PollingDayTime)
		<tr>
			<td>{{ $PollingDayTime->BlocksMc->name_e or ''}}</td>
			<td>{{ $PollingDayTime->polling_day_time_e }}</td>
			<td>{{ $PollingDayTime->polling_day_time_l }}</td>
		</tr> 
		@endforeach
	</tbody>
</table>