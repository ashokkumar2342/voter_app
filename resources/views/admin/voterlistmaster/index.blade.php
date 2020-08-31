@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Voter List Master</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <form action="{{ route('admin.VoterListMaster.store') }}" method="post" class="add_form">
                {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Name</label>
                          <input type="text" name="voter_list_name" class="
                          form-control" maxlength="50">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Type</label>
                          <input type="text" name="voter_list_type" class="
                          form-control" maxlength="50">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Year Publication</label>
                          <input type="text" name="year_publication" class="form-control" maxlength="50" {{-- onkeypress='return event.charCode >= 48 && event.charCode <= 57' --}} >
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Date Publication</label>
                          <input type="text" name="date_publication" class="form-control" maxlength="50">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Year Base</label>
                          <input type="text" name="year_base" class="form-control"
                          maxlength="50">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Date Base</label>
                          <input type="text" name="date_base" class="form-control"
                          maxlength="50">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks1</label>
                          <input type="text" name="remarks1" class="form-control">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks2</label>
                          <input type="text" name="remarks2" class="form-control">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks3</label>
                          <input type="text" name="remarks3" class="form-control">
                    </div>
                    <div class="col-lg-4 text-center" style="margin-top: 30px">  
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="radioPrimary3" name="is_supplement" value="1" >
                      <label for="radioPrimary3">Is Supplement</label>  
                    </div>
                  </div> 
                    <div class="col-lg-8 form-group">                        
                          <input type="submit" class="form-control btn-success" style="margin-top: 30px">
                    </div>

                </div>
            </form>
            </div> 
        </div>
    </div> 
</section>
@endsection



