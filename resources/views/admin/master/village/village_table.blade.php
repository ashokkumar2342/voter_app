<div class="card card-primary table-responsive"> 
                             <table id="district_table" class="table table-striped table-hover control-label">
                                 <thead>
                                     <tr>
                                         <th class="text-nowrap">States</th>
                                         <th class="text-nowrap">District</th>
                                         <th class="text-nowrap">Block MCS</th>
                                         <th class="text-nowrap">Code</th>
                                         <th class="text-nowrap">Name (Eng.)</th>
                                         <th class="text-nowrap">Name (Local Lang.)</th>
                                         <th class="text-nowrap">(Total Ward)</th>
                                         <th class="text-nowrap">Action</th>
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($Villages as $Village)
                                    @php
                                        $WardVillage=App\Model\WardVillage::where('village_id',$Village->id)->count('ward_no'); 
                                    @endphp
                                     <tr>
                                         <td>{{ $Village->states->name_e or '' }}</td>
                                         <td>{{ $Village->district->name_e or '' }}</td>
                                         <td>{{ $Village->blockMCS->name_e or '' }}</td>
                                         <td>{{ $Village->code }}</td>
                                         <td>{{ $Village->name_e }}</td>
                                         <td>{{ $Village->name_l }}</td>
                                         <td>{{ $WardVillage }}</td>
                                         <td class="text-nowrap">
                                            <button type="button" class="btn btn-primary btn-xs" onclick="callPopupLarge(this,'{{ route('admin.Master.village.ward.add',$Village->id) }}')">Add Ward</button>
                                             <a onclick="callPopupLarge(this,'{{ route('admin.Master.village.edit',$Village->id) }}')" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                             <a href="#" success-popup="true" select-triger="block_select_box" onclick="callAjax(this,'{{ route('admin.Master.village.delete',$Village->id) }}')" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                         </td>
                                     </tr> 
                                    @endforeach
                                 </tbody>
                             </table>
                        </div> 