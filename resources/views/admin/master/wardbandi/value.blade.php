<div class="col-lg-12"> 
  <div class="card card-info"> 
    <div class="card-body">
      <div class="row"> 
      <div class="col-lg-6 form-group">
        <label>Assembly--Part</label>
        <select name="assembly_part" id="assembly_part_select_box" class="form-control select2" data-table="voter_list_table" onchange="callAjax(this,'{{ route('admin.Master.WardBandiFilterAssemblyPart') }}','voter_list');disablewardNo()">
          <option selected disabled>Select Assembly--Part</option>
          @foreach ($assemblyParts as $assemblyPart)
          <option value="{{ $assemblyPart->id }}">{{ $assemblyPart->assembly->code or '' }}--{{ $assemblyPart->part_no }}</option> 
          @endforeach 
        </select> 
      </div>
      <div class="col-lg-6 form-group">
        <label>Ward</label>
        <select name="ward" id="ward_select_box" disabled class="form-control select2" onchange="callAjax(this,'{{ route('admin.Master.WardBandiFilterward') }}','sr_no_form')">
          <option selected disabled>Select Ward</option> 
          @foreach ($WardVillages as $WardVillage)
          @if ($WardVillage->lock==1)
           @else  
          <option value="{{ $WardVillage->id }}">{{ $WardVillage->ward_no or '' }}</option> 
          @endif
          @endforeach 
        </select> 
      </div>  
      </div> 
    </div>
  </div>  
<div class="row" style="margin-top: 20px"> 
  <div class="col-lg-12" id="sr_no_form">
    
  </div>
  <div class="col-lg-12" id="voter_list">
    
  </div>
</div>
</div>
 