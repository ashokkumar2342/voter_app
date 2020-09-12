<form action="{{ route('admin.Master.MappingVillageTowardStore') }}" method="get" enctype="multipart/form-data" success-content-id="village_ward_imported_table" no-reset="true" data-table-without-pagination="village_sample_table" class="add_form">
<div class="row">
<div class="col-lg-10 form-group">
<label for="exampleInputFile">Import File</label>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="exampleInputFile" name="import_file">
<label class="custom-file-label" for="exampleInputFile">Choose file</label>
</div> 
</div>
</div> 
<div class="col-lg-2 form-group">
 <input type="submit" class="btn btn-success" style="margin-top: 30px">
</div> 
</div>
<div class="col-lg-12 table-responsive" id="village_ward_imported_table">
 	
 </div> 
</form>