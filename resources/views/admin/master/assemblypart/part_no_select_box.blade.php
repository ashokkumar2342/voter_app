<option selected disabled>Select Part</option> 
@foreach ($Parts as $Part)
@if (in_array($Part->id,$OldParts))
@else
<option value="{{ $Part->id }}">{{ $Part->part_no }}</option>
@endif 
@endforeach 