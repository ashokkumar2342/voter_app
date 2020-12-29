<form action="{{ route('admin.search.voter.folter',2) }}" method="post" class="add_form" data-table="voter_datatable" success-content-id="voter_table" no-reset="true">
    {{ csrf_field() }}
    <div class="row">  
        <div class="col-lg-4 form-group">
            <label for="exampleInputEmail1">District</label>
            
            <select name="district" class="form-control" id="district_select_box" onchange="callAjax(this,'{{ route('admin.search.dis.block') }}','block_select_box')">
                <option selected disabled>Select District</option>
                @foreach ($Districts as $District)
                <option value="{{ $District->id }}">{{ $District->code }}--{{ $District->name_e }}</option>  
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 form-group">
            <label for="exampleInputEmail1">Block MCS</label>
            
            <select name="block" class="form-control" id="block_select_box" onchange="callAjax(this,'{{ route('admin.search.block.village') }}'+'?id='+this.value+'&district_id='+$('#district_select_box').val(),'village_select_box')">
                <option selected disabled>Select Block MCS</option> 
            </select>
        </div> 
        <div class="col-lg-4 form-group">
            <label for="exampleInputEmail1">Village</label>
            
            <select name="village" class="form-control" id="village_select_box">
                <option selected disabled>Select Village</option> 
            </select>
        </div> 
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control"> 
        </div>
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">F/H Name</label>
            <input type="text" name="father_name" class="form-control"> 
        </div>
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">Age</label>
            <input type="text" name="age" class="form-control"> 
        </div>
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">Mobile No.</label>
            <input type="text" name="father_name" class="form-control"> 
        </div>
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">Mobile No.</label>
            <input type="text" name="father_name" class="form-control"> 
        </div>
        <div class="col-lg-2 form-group">
            <label for="exampleInputEmail1">Mobile No.</label>
            <input type="text" name="father_name" class="form-control"> 
        </div>
        <div class="col-lg-12 form-group">
            <input type="submit" id="btn_show" value="Search" class="form-control btn btn-success">
        </div>
    </div>
</form>
<div id="voter_table">

</div>