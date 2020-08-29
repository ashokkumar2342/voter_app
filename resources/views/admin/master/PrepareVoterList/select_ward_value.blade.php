
<label for="exampleInputEmail1">Ward No.</label>
<span class="fa fa-asterisk"></span>
<select class="multiselect form-control" multiple="multiple"  name="ward_no[]">
@foreach ($WardVillages as $WardVillage)
	 <option value="{{ $WardVillage->id }}">{{ $WardVillage->ward_no }}</option>
@endforeach
</select>
</div>