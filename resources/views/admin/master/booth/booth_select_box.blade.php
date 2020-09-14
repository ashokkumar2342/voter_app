<option selected disabled>Select Booth</option>
@foreach ($booths as $booth)
 	<option value="{{ $booth->id }}">{{ $booth->booth_no }}</option> 
 @endforeach 