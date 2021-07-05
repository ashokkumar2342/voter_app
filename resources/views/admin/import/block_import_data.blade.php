<div class="col-lg-12">
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i>Import Successfully</h5> 
    </div>
</div> 
<table class="table" id="block_imported_datatable">
	<thead>
	   <tr> 
	        
	       <th>district_id</th>
	       <th>block_code</th>
	       <th>block_name_eng</th>
	       <th>block_name_hindi</th>
	       <th>block_mc_type_id</th>
	       <th>total_wards</th>
	       <th>save_status</th>
	   </tr>
	</thead>
	<tbody>
	@foreach ($BloImportedDatas as $BloImportedDatas) 
	   <tr>
	       
	       <td>{{ $BloImportedDatas->district_id }}</td>
	       <td>{{ $BloImportedDatas->bcode }}</td>
	       <td>{{ $BloImportedDatas->bname_e }}</td>
	       <td>{{ $BloImportedDatas->bname_l }}</td>
	       <td>{{ $BloImportedDatas->block_mc_type_id }}</td>
	       <td>{{ $BloImportedDatas->total_wards }}</td>
	       <td>{{ $BloImportedDatas->save_status }}</td>
	        
	   </tr>
	@endforeach
	</tbody>
</table>