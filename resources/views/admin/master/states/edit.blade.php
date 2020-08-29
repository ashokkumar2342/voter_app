<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.store',$States->id) }}" method="post" class="add_form" content-refresh="state_table" button-click="btn_close">
        {{ csrf_field() }}
        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputEmail1">States Code</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="code" class="form-control" placeholder="Enter Code" value="{{ $States->code }}" maxlength="5">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">States Name (English)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" value="{{ $States->name_e }}" maxlength="50">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">States Name (Local Language)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" value="{{ $States->name_l }}" maxlength="50">
          </div> 
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

