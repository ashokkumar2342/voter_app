
<option value="0">All</option>
@foreach ($booths as $booth)
<option value="{{ $booth->id }}">{{ $booth->booth_no }}-{{ $booth->name_e }}</option> 
@endforeach