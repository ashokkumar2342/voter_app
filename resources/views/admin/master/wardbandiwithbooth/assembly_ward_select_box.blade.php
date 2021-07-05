<div class="row">
<div class="col-lg-4 form-group">
<label>Assembly--Part</label>
<select name="assembly_part" id="assembly_part_select_box" class="form-control select2" data-table="voter_list_table" onchange="callAjax(this,'{{ route('admin.Master.AssemblywisevoterMapped') }}','voter_list');disablewardNo()">
<option selected disabled>Select Assembly--Part</option>
@foreach ($assemblyParts as $assemblyPart)
<option value="{{ $assemblyPart->id }}">{{ $assemblyPart->assembly->code or '' }}--{{ $assemblyPart->part_no }}</option> 
@endforeach 
</select> 
</div>
<div class="col-lg-4 form-group">
<label>Ward</label>
<select name="ward" id="ward_select_box" class="form-control select2" onchange="callAjax(this,'{{ route('admin.Master.WardWiseBooth') }}'+'?ward_id='+this.value+'&village_id='+$('#village_select_box').val(),'booth_select_box')">
<option selected disabled>Select Ward</option> 
@foreach ($WardVillages as $WardVillage)
@if ($WardVillage->lock==1)
@else  
<option value="{{ $WardVillage->id }}">{{ $WardVillage->ward_no or '' }}</option> 
@endif
@endforeach 
</select> 
</div>
<div class="col-lg-4">
<label>Booth No.</label>
<select name="booth" class="form-control" onchange="callAjax(this,'{{ route('admin.Master.BoothWiseTotalMappedWard') }}','sr_no_form')" id="booth_select_box">
<option selected disabled>Select Booth No.</option> 
</select> 
</div> 
</div> 

<div class="col-lg-12" id="booth_select_box">

</div>  
<div class="row" style="margin-top: 20px"> 
<div class="col-lg-12" id="sr_no_form">

</div>
<div class="col-lg-12" id="voter_list">

</div>
</div>
</div>
