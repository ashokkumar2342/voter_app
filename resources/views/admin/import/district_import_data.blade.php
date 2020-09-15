<div class="col-lg-12">
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-check"></i>Import Successfully</h5> 
    </div>
</div> 
<table class="table" id="district_imported_datatable">
	<thead>
	   <tr> 
	       <th>state_id</th>
	       <th>district_code</th>
	       <th>district_name_eng</th>
	       <th>district_name_hindi</th>
	       <th>total_wards</th>
	       <th>save_status</th>
	   </tr>
	</thead>
	<tbody>
	@foreach ($disImportedDatas as $disImportedData) 
	   <tr>
	       <td>{{ $disImportedData->state_id }}</td>
	       <td>{{ $disImportedData->dcode }}</td>
	       <td>{{ $disImportedData->dname_e }}</td>
	       <td>{{ $disImportedData->dname_l }}</td>
	       <td>{{ $disImportedData->total_wards }}</td>
	       <td>{{ $disImportedData->save_status }}</td>
	        
	   </tr>
	@endforeach
	</tbody>
</table>