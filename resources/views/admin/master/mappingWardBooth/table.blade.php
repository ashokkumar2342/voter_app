@foreach ($booths as $booth)
	<tr>
		<td>{{ $booth->booth_no }}</td>
		<td>{{ $booth->fromsrno }}</td>
		<td>{{ $booth->tosrno }}</td>
		<td>
			<a href="" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
			<a href="" title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
		</td>
	</tr> 
@endforeach