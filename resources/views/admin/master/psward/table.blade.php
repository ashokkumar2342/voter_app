<table id="ps_ward_datatable" class="table table-striped table-hover control-label">
     <thead>
         <tr>
             <th>States</th>
             <th>District</th> 
             <th>Block</th> 
             <th>P.S.Ward No.</th>
             <th>P.S.Ward No.(Eng)</th>
             <th>P.S.Ward No.(Local Lung)</th>
             <th>Action</th>
              
              
         </tr>
     </thead>
     <tbody>
     	@foreach ($PanchayatSamitis as $PanchayatSamiti)
     	<tr>
     		<td>{{ $PanchayatSamiti->States->name_e or ''}}</td>
     		<td>{{ $PanchayatSamiti->Districts->name_e or ''}}</td>
            <td>{{ $PanchayatSamiti->Blocks->name_e or ''}}</td>
     		<td>{{ $PanchayatSamiti->ward_no }}</td>
     		<td>{{ $PanchayatSamiti->name_e }}</td>
     		<td>{{ $PanchayatSamiti->name_l }}</td>
            <td>
                <a href="#" class="btn btn-xs btn-info" onclick="callPopupLarge(this,'{{ route('admin.Master.PanchayatSamitiEdit',$PanchayatSamiti->id) }}')"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-xs btn-danger" success-popup="true" select-triger="block_select_box" onclick="callAjax(this,'{{ route('admin.Master.PanchayatSamitiDelete',$PanchayatSamiti->id) }}')"><i class="fa fa-trash"></i></a>
            </td>
     	</tr>	 
     	@endforeach 
     </tbody>
 </table>