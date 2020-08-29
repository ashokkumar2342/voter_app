@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Ward Village</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary"> 
                            <form action="{{ route('admin.Master.ward.store') }}" method="post" class="add_form" content-refresh="district_table">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row"> 
                                    <div class="col-lg-6 form-group">
                                        <label for="exampleInputEmail1">States</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="states" class="form-control" onchange="callAjax(this,'{{ route('admin.Master.stateWiseDistrict') }}','district_select_box')">
                                            <option selected disabled>Select States</option>
                                            @foreach ($States as $State)
                                            <option value="{{ $State->id }}">{{ $State->code }}--{{ $State->name_e }}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="exampleInputEmail1">District</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="district" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.Master.DistrictWiseBlock') }}','block_select_box')">
                                            <option selected disabled>Select District</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Block MCS</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="block_mcs" class="form-control" id="block_select_box" onchange="callAjax(this,'{{ route('admin.Master.BlockWiseVillage') }}','village_select_box')">
                                            <option selected disabled>Select Block MCS</option>
                                             
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Village</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="village" class="form-control" id="village_select_box">
                                            <option selected disabled>Select Village</option>
                                            
                                        </select>
                                    </div> 
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">How Many Ward To Create</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="ward" class="form-control" placeholder="" maxlength="5">
                                    </div> 
                                </div> 
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-primary table-responsive"> 
                             <table id="district_table" class="table table-striped table-hover control-label">
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
                    </div> 
                </div>
            </div> 
        </div> 
    </section>
    @endsection
    <script type="text/javascript">
        $('#ddd').DataTable();
    </script> 

