<option selected disabled>Select Village</option>
@foreach ($Villages as $Village)
<option value="{{ $Village->id }}">{{ $Village->code }}--{{ $Village->name_e }}</option>  
@endforeach