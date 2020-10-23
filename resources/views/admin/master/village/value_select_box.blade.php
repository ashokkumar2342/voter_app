<option selected disabled>Select Village</option>
@foreach ($Villages as $Village)
<option value="{{ $Village->id }}">{{ $Village->code }}--{{ $Village->name_e }} {{ $Village->is_locked==1?'(Locked)':'' }}</option>  
@endforeach