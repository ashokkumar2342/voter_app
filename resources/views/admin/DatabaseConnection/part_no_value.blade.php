	 	 
@foreach ($partnos as $partno)
@php
	$totalImport=App\Model\Voter::where('assembly_id',$partno->assembly_id)->where('assembly_part_id',$partno->id)->count();
@endphp
<tr>
<td>
<div class="icheck-primary d-inline">
<input type="checkbox" name="part_no[]" value="{{ $partno->part_no }}" id="{{ $partno->part_no }}{{ $partno->assembly_id }}"  class="checkbox">
<label for="{{ $partno->part_no }}{{ $partno->assembly_id }}" class="checkbox"></label>
</div> 
</td> 
<td>{{ $partno->part_no}}</td>
<td>{{ $totalImport }}</td> 
<td>
	@if ($totalImport!=0) 
	 <a href="#" title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
	@endif
</td> 
</tr> 
@endforeach 
 