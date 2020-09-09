<table class="table" id="village_imported_datatable">
	<thead>
	   <tr> 
	       <th>state_id</th>
	       <th>district_id</th>
	       <th>block_id</th>
	       <th>village_code</th>
	       <th>village_name_eng</th>
	       <th>village_name_hindi</th>
	       <th>total_parts</th>
	       <th>save_status</th>
	   </tr>
	</thead>
	<tbody>
	@foreach ($VillImportedDatas as $VillImportedData) 
	   <tr>
	       <td>{{ $VillImportedData->state_id }}</td>
	       <td>{{ $VillImportedData->district_id }}</td>
	       <td>{{ $VillImportedData->block_id }}</td>
	       <td>{{ $VillImportedData->vcode }}</td>
	       <td>{{ $VillImportedData->vname_e }}</td>
	       <td>{{ $VillImportedData->vname_l }}</td>
	       <td>{{ $VillImportedData->total_ward }}</td>
	       <td>{{ $VillImportedData->save_status }}</td>
	        
	   </tr>
	@endforeach
	</tbody>
</table>