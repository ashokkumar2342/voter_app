@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Voter Details</h3>
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
                            <form action="{{ route('admin.voter.details.store') }}" method="post" class="add_form" content-refresh="district_table" no-reset="true">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">  
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">District</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="district" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.voter.districtWiseAssembly') }}','assembly_select_box');callAjax(this,'{{ route('admin.voter.districtWiseVillage') }}','village_select_box')">
                                            <option selected disabled>Select District</option>
                                            @foreach ($Districts as $District)
                                            <option value="{{ $District->id }}">{{ $District->code }}--{{ $District->name_e }}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Assembly</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="assembly" class="form-control" id="assembly_select_box" onchange="callAjax(this,'{{ route('admin.voter.AssemblyWisePartNo') }}','part_no_select_box')">
                                            <option selected disabled>Select Assembly</option>
                                             
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Village</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="village" class="form-control" id="village_select_box" onchange="callAjax(this,'{{ route('admin.voter.VillageWiseWard') }}','ward_no_select_box')">
                                            <option selected disabled>Select Village</option> 
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="exampleInputEmail1">Part No.</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="part_no" class="form-control" id="part_no_select_box" >
                                            <option selected disabled>Select Part No.</option> 
                                        </select>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="exampleInputEmail1">Ward No.</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="ward_no" class="form-control" id="ward_no_select_box" >
                                            <option selected disabled>Select Ward No.</option> 
                                        </select>
                                    </div>
                                    
                                </div>
                            </div> 
                            <div class="card-body">
                                    <div class="row"> 
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">House No.</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="house_no" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Voter Name</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="voter_name" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">F/H Name</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="father_name" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Relation</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="relation" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Gender</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="gender" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.voter.districtWiseAssembly') }}','assembly_select_box')">
                                            <option selected disabled>Select Gender</option>
                                            @foreach ($genders as $gender)
                                            <option value="{{ $gender->id }}">{{ $gender->genders }}</option>  
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Date of Birth</label>
                                        
                                        <input type="date" name="date_of_birth" class="form-control" onchange="callAjax(this,'{{ route('admin.voter.calculateAge') }}','age_value_div')">
                                    </div>
                                    <div class="col-lg-4 form-group" id="age_value_div">
                                        <label for="exampleInputEmail1">Age</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="age" class="form-control" >
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Voter ID No.</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="voter_id_no" class="form-control">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Mobile No.</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="mobile_no" class="form-control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label for="exampleInputFile">Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group"> 
                                        <input type="submit"  class="btn btn-success form-control" style="margin-top: 30px">
                                    </div>
                                </div>
                            </div> 
                            </form>
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

