<div class="card card-primary table-responsive"> 
                             <table id="district_table" class="table table-striped table-hover control-label">
                                 <thead>
                                     <tr>
                                          
                                         <th>Sr.No.</th>
                                         <th>Name</th>
                                         <th>F/H Name</th>
                                         <th>Ward</th>
                                         
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($voters as $voters)
                                     <tr href="">
                                          
                                         
                                         <td>{{ $voters->sr_no }}</td>
                                         <td>{{ $voters->name_e }}</td>
                                         <td>{{ $voters->father_name }}</td>
                                         <td>{{ $voters->ward_id }}</td>
                                          
                                     </tr> 
                                    @endforeach
                                 </tbody>
                             </table>
                        </div> 