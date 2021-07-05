<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.PanchayatSamitiUpdate',$PanchayatSamiti->id) }}" method="post" class="add_form" select-triger="block_select_box" button-click="btn_close">
        {{ csrf_field() }}
        <div class="card-body">
          <div class="form-group">
            <label>P.S.Ward No.</label>
            <input type="text" class="form-control" name="ps_ward_no" value="{{ $PanchayatSamiti->ward_no }}"> 
          </div>
          <div class="form-group">
            <label>P.S.Name (English)</label>
            <input type="text" class="form-control" name="ps_ward_name_english" value="{{ $PanchayatSamiti->name_e }}"> 
          </div>
          <div class="form-group">
            <label>P.S.Name (Local Language)</label>
            <input type="text" class="form-control" name="ps_ward_name_local_language" value="{{ $PanchayatSamiti->name_l }}"> 
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

