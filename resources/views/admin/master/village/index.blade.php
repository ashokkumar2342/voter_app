@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Village</h3>
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
                            <form action="{{ route('admin.Master.village.store') }}" method="post" class="add_form" content-refresh="district_table">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row"> 
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">States</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="states" class="form-control" onchange="callAjax(this,'{{ route('admin.Master.stateWiseDistrict') }}','district_select_box')">
                                            <option selected disabled>Select States</option>
                                            @foreach ($States as $State)
                                            <option value="{{ $State->id }}">{{ $State->code }}--{{ $State->name_e }}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">District</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="district" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.Master.DistrictWiseBlock') }}','block_select_box')">
                                            <option selected disabled>Select District</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Block MCS</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="block_mcs" class="form-control" id="block_select_box">
                                            <option selected disabled>Select Block MCS</option>
                                             
                                        </select>
                                    </div> 
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Village Code</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="code" class="form-control" placeholder="Enter Code" maxlength="5">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputPassword1">Village Name (English)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputPassword1">Village Name (Local Language)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50">
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
                                             <a onclick="callPopupLarge(this,'{{ route('admin.Master.village.edit',$Village->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="{{ route('admin.Master.village.delete',$Village->id) }}" title="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                         </td>
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

