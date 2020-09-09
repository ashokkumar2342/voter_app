<table class="table" id="assembly_imported_datatable">
	<thead>
	   <tr> 
	       <th>district_id</th>
	       <th>assembly_code</th>
	       <th>assembly_name_eng</th>
	       <th>assembly_name_hindi</th>
	       <th>total_parts</th>
	       <th>save_status</th>
	   </tr>
	</thead>
	<tbody>
	@foreach ($AssImportedDatas as $AssImportedData) 
	   <tr>
	       <td>{{ $AssImportedData->district_id }}</td>
	       <td>{{ $AssImportedData->acode }}</td>
	       <td>{{ $AssImportedData->aname_e }}</td>
	       <td>{{ $AssImportedData->aname_l }}</td>
	       <td>{{ $AssImportedData->total_parts }}</td>
	       <td>{{ $AssImportedData->save_status }}</td>
	        
	   </tr>
	@endforeach
	</tbody>
</table>