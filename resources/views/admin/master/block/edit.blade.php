<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.BlockMCSStore',$BlocksMcs->id) }}" method="post" class="add_form" select-triger="district_select_box" button-click="btn_close">
        {{ csrf_field() }}
        <div class="box-body"> 
        <div class="row"> 
            <input type="hidden" name="district" value="{{ $BlocksMcs->districts_id }}"> 
          <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Block Code</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="code" class="form-control" placeholder="Enter Code" value="{{ $BlocksMcs->code }}" maxlength="5">
          </div>
          <div class="form-group col-lg-4">
            <label for="exampleInputPassword1">Block Name(English)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" value="{{ $BlocksMcs->name_e }}" maxlength="50">
          </div>
          <div class="form-group col-lg-4">
            <label for="exampleInputPassword1">Block Name(Local Lang)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" value="{{ $BlocksMcs->name_l }}" maxlength="50">
          </div> 
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

