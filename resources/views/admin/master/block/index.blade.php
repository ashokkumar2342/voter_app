@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Block MCS</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <form action="{{ route('admin.Master.BlockMCSStore') }}" method="post" class="add_form" content-refresh="district_table">
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
                                        <select name="district" class="form-control" id="district_select_box">
                                            <option selected disabled>Select District</option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Block MCS Code</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="code" class="form-control" placeholder="Enter Code" maxlength="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Block MCS Name (English)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Block MCS Name (Local Language)</label>
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
                    <div class="col-lg-6">
                        <div class="card card-primary table-responsive"> 
                             <table id="district_table" class="table table-striped table-hover control-label">
                                 <thead>
                                     <tr>
                                         <th>States</th>
                                         <th>District</th>
                                         <th>Code</th>
                                         <th>Name (English)</th>
                                         <th>Name (Local Language)</th>
                                         <th>Action</th>
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($BlocksMcs as $BlockMc)
                                     <tr>
                                         <td>{{ $BlockMc->states->name_e or '' }}</td>
                                         <td>{{ $BlockMc->district->name_e or '' }}</td>
                                         <td>{{ $BlockMc->code }}</td>
                                         <td>{{ $BlockMc->name_e }}</td>
                                         <td>{{ $BlockMc->name_l }}</td>
                                         <td class="text-nowrap">
                                             <a onclick="callPopupLarge(this,'{{ route('admin.Master.BlockMCSEdit',$BlockMc->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="{{ route('admin.Master.BlockMCSDelete',Crypt::encrypt($BlockMc->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

