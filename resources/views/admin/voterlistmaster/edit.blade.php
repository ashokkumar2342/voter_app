<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.VoterListMaster.store',$VoterListMaster->id) }}" method="post" class="add_form" content-refresh="voter_list_master" button-click="btn_close">
                {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Name</label>
                          <input type="text" name="voter_list_name" class="
                          form-control" maxlength="200" value="{{ $VoterListMaster->voter_list_name }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Type</label>
                          <input type="text" name="voter_list_type" class="
                          form-control" maxlength="200" value="{{ $VoterListMaster->voter_list_type }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Publication Year</label>
                          <input type="text" name="publication_year" class="form-control" maxlength="4" value="{{ $VoterListMaster->year_publication }}" >
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Date of Publication</label>
                          <input type="text" name="date_of_publication" class="form-control" maxlength="20" value="{{ $VoterListMaster->date_publication }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Base Year</label>
                          <input type="text" name="base_year" class="form-control"
                          maxlength="4" value="{{ $VoterListMaster->year_base }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Base Date</label>
                          <input type="text" name="base_date" class="form-control"
                          maxlength="20" value="{{ $VoterListMaster->date_base }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks1</label>
                          <input type="text" name="remarks1" class="form-control" maxlength="100" value="{{ $VoterListMaster->remarks1 }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks2</label>
                          <input type="text" name="remarks2" class="form-control" maxlength="100" value="{{ $VoterListMaster->remarks2 }}">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks3</label>
                          <input type="text" name="remarks3" class="form-control" maxlength="100" value="{{ $VoterListMaster->remarks3 }}">
                    </div>
                     @php
                       if ($VoterListMaster->is_supplement==1) {
                          $checked='checked';
                       }else{
                        $checked='';
                       }

                     @endphp
                    <div class="col-lg-4 text-center" style="margin-top: 30px">  
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="radioPrimary4" name="is_supplement" value="1" {{ $checked }}>
                      <label for="radioPrimary4">Is Supplement</label>  
                    </div>
                  </div> 
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

