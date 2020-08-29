<div class="card card-info">
  <div class="card-header">
     <h3 class="card-title">Total Mapped : {{ $total_mapped[0]->total_mapped }}</h3>
    </div> 
    <div class="card-body" >
    <div class="row"> 
       <div class="col-lg-6 form-group">
       	<label>From Sr.No.</label>
       	<input type="text" name="from_sr_no" class="form-control"> 
        </div>
        <div class="col-lg-6 form-group">
       	<label>To Sr.No.</label>
       	<input type="text" name="to_sr_no" class="form-control"> 
        </div>
    </div>    
        <div class="row"> 
          <div class="col-lg-4 form-group">
	       	<div class="icheck-primary d-inline">
	          <input type="checkbox" value="1" name="forcefully" id="todoCheck1" >
	          <label for="todoCheck1">Forcefully Move</label>
	        </div>
         </div>
         <div class="col-lg-4 form-group"> 
       	 <input type="submit" class="btn btn-success form-control"> 
         </div>
         <div class="col-lg-4 form-group"> 
         <button type="button" class="btn btn-primary form-control" onclick="callPopupLarge(this,'{{ route('admin.Master.WardBandiReport') }}'+'?village='+$('#village_select_box').val()+'&assembly_part='+$('#assembly_part_select_box').val()+'&ward='+$('#ward_select_box').val())">Report</button> 
         </div>
        </div>    
    </div>
  </div>
</div>
