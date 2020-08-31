
<label for="exampleInputEmail1">Ward No.</label>
<span class="fa fa-asterisk"></span>
 <select class="selectpicker multiselect" multiple data-live-search="true">
 @foreach ($WardVillages as $WardVillage)
 	 <option value="{{ $WardVillage->id }}">{{ $WardVillage->ward_no }}</option>
 @endforeach                                     
 </select>
</div>



