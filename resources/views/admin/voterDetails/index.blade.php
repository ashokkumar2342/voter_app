@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add New Voter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body"> 
                <form action="{{ route('admin.voter.details.store') }}" method="post" class="add_form" no-reset="true" select-triger="village_select_box" reset-input-text="name_english,name_local_language,f_h_name_english,f_h_name_local_language,relation,house_no_english,house_no_local_language,district_select_box,date_of_birth,age,voter_id_no,mobile_no,exampleInputFile,Aadhaar_no">
                    {{ csrf_field() }} 
                    <div class="row">  
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">District</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="district" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.Master.DistrictWiseBlock') }}','block_select_box');callAjax(this,'{{ route('admin.voter.districtWiseAssembly') }}','assembly_select_box')">
                                <option selected disabled>Select District</option>
                                @foreach ($Districts as $District)
                                <option value="{{ $District->id }}">{{ $District->code }}--{{ $District->name_e }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Block MCS</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="block" class="form-control" id="block_select_box" onchange="callAjax(this,'{{ route('admin.Master.BlockWiseVillage') }}'+'?id='+this.value+'&district_id='+$('#district_select_box').val(),'village_select_box')">
                                <option selected disabled>Select Block MCS</option> 
                            </select>
                        </div> 
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Village</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="village" class="form-control" id="village_select_box" onchange="callAjax(this,'{{ route('admin.voter.VillageWiseWard') }}','ward_no_select_box');callAjax(this,'{{ route('admin.voter.VillageWiseVoterList') }}'+'?village_id='+this.value,'voter_list_table')">
                                <option selected disabled>Select Village</option> 
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Ward No.</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="ward_no" class="form-control" id="ward_no_select_box" >
                                <option selected disabled>Select Ward No.</option> 
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
                            <label for="exampleInputEmail1">Part No.</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="part_no" class="form-control" id="part_no_select_box" onchange="callAjax(this,'{{ route('admin.Master.WardWiseBooth') }}'+'?village_id='+$('#village_select_box').val()+'&ward_id='+$('#ward_no_select_box').val(),'booth_select_box')">
                                <option selected disabled>Select Part No.</option> 
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputEmail1">Booth No.</label>
                            
                            <select name="part_no" class="form-control" id="booth_select_box">
                                <option selected disabled>Select Booth No.</option> 
                            </select>
                        </div> 
                    </div> 
                    <div class="row"> 
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">Name (English)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="name_english" id="name_english" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group" id="name_local_language">
                            <label for="exampleInputEmail1">Name (Local Language)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="name_local_language"  class="form-control">
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputEmail1">Relation</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="relation" id="relation" class="form-control">
                                <option selected disabled>Select Relation</option>
                                @foreach ($Relations as $Relation)
                                <option value="{{ $Relation->id }}">{{ $Relation->relation_e }}-{{ $Relation->relation_l }}</option> 
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputEmail1">F/H Name (English)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="f_h_name_english" id="f_h_name_english" class="form-control">
                        </div>
                        <div class="col-lg-4 form-group" id="f_h_name_local_language">
                            <label for="exampleInputEmail1">F/H Name (Local Language)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="f_h_name_local_language" class="form-control">
                        </div> 
                        <div class="col-lg-6 form-group">
                            <label for="exampleInputEmail1">House No.(English)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="house_no_english" id="house_no_english" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group" id="house_no_local_language">
                            <label for="exampleInputEmail1">House No.(Local Language)</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="house_no_local_language" class="form-control">
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Gender</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="gender" class="form-control" id="gender">
                                <option selected disabled>Select Gender</option>
                                @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}">{{ $gender->genders }}-{{ $gender->genders_l }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Date of Birth</label>

                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" onchange="callAjax(this,'{{ route('admin.voter.calculateAge') }}','age_value_div')">
                        </div>
                        <div class="col-lg-3 form-group" id="age_value_div">
                            <label for="exampleInputEmail1">Age</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="age" id="age" class="form-control" >
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="exampleInputEmail1">Voter ID No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="voter_id_no" id="voter_id_no" class="form-control">
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputEmail1">Aadhaar No.</label> 
                            <input type="text" name="Aadhaar_no" id="Aadhaar_no" class="form-control">
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputEmail1">Mobile No.</label> 
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control">
                        </div>
                        <div class="col-lg-4 form-group">
                            <label for="exampleInputFile">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-12 form-group"> 
                            <input type="submit"  class="btn btn-success form-control" style="margin-top: 30px">
                        </div>
                     </div>
                 </form>
                 <div id="voter_list_table">
                     
                 </div>
             </div>
         </div>
     </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript"> 
$("#name_english").keydown(function(event){  
    if (event.keyCode == 9) {
        callAjax(this,'{{ route('admin.voter.NameConvert',1) }}'+'?name_english='+$('#name_english').val(),'name_local_language'); 
    }
});
$("#f_h_name_english").keydown(function(event){  
    if (event.keyCode == 9) {

        callAjax(this,'{{ route('admin.voter.NameConvert',2) }}'+'?name_english='+$('#f_h_name_english').val(),'f_h_name_local_language');

    }
});
$("#house_no_english").keydown(function(event){  
    if (event.keyCode == 9) {

        callAjax(this,'{{ route('admin.voter.NameConvert',3) }}'+'?name_english='+$('#house_no_english').val(),'house_no_local_language');

    }
});
</script> 
@endpush

