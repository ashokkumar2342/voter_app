<div class="col-lg-6"> 
  <div class="card card-primary">
  <div class="card-header">
     <h3 class="card-title"></h3>
    </div> 
    <div class="card-body">
       <table class="table">
         <thead>
           <tr>
             <th>Assembly Code</th>
             <th>Part No.</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
          @foreach ($assemblyParts as $assemblyPart)
           <tr>
             <td>{{ $assemblyPart->assembly->name_e or ''}}</td>
             <td>{{ $assemblyPart->part_no }}</td>
             <td class="text-center">
               <a onclick="callAjax(this,'{{ route('admin.Master.MappingVillageAssemblyPartRemove',$assemblyPart->id) }}')" title="Remove" class="btn" select-triger="village_select_box" success-popup="true"><i class="fa fa-remove text-danger"></i></a>
             </td>
           </tr> 
          @endforeach
         </tbody>
       </table>
    </div>
  </div>
</div>
<div class="col-lg-6"> 
  <div class="card card-info">
    
    <div class="card-body">
      <div class="row"> 
      <div class="col-lg-6 form-group">
        <label>Assembly</label>
        <select name="assembly" class="form-control" id="assembly_select_box" onchange="callAjax(this,'{{ route('admin.Master.MappingAssemblyWisePartNo') }}'+'?village_id='+$('#village_select_box').val(),'part_no_select_box')">
          <option selected disabled>Select Assembly</option> 
          @foreach ($assemblys as $assembly)
          <option value="{{ $assembly->id }}">{{ $assembly->name_e }}</option> 
          @endforeach 
        </select> 
      </div>
      <div class="col-lg-6 form-group">
        <label>Part No.</label>
        <select name="part_no" class="form-control" id="part_no_select_box">
          <option selected disabled>Select Part</option> 
            
        </select> 
      </div>
      <div class="col-lg-12 form-group text-center">
        <input type="submit" class="btn btn-success">
      </div>
      </div> 
    </div>
  </div>
</div>
