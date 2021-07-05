<div class="card card-primary table-responsive"> 
     <table id="ward_datatable" class="table table-striped table-hover control-label">
         <thead>
             <tr>
                 <th class="text-nowrap">States</th>
                 <th class="text-nowrap">District</th>
                 <th class="text-nowrap">Block MCS</th>
                 <th class="text-nowrap">Village MCS</th>
                 <th class="text-nowrap">Ward No.</th>
                 <th class="text-nowrap">Ward Name (Eng)</th>
                 <th class="text-nowrap">Ward Name (Local Lang)</th>
                  
                  
             </tr>
         </thead>
         <tbody>
            @foreach ($wards as $ward)
             <tr>
                 <td>{{ $ward->states->name_e or '' }}</td>
                 <td>{{ $ward->district->name_e or '' }}</td>
                 <td>{{ $ward->blockMCS->name_e or '' }}-{{ $ward->blockMCS->name_l or '' }}</td>
                 <td>{{ $ward->village->name_e or '' }}-{{ $ward->village->name_l or '' }}</td>
                 <td>{{ $ward->ward_no }}</td>
                 <td>{{ $ward->name_e }}</td>
                 <td>{{ $ward->name_l }}</td>
                 
             </tr> 
            @endforeach
         </tbody>
     </table>
</div> 