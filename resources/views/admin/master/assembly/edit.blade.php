<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.Assembly.store',$assembly->id) }}" method="post" class="add_form" select-triger="district_select_box" button-click="btn_close">
        {{ csrf_field() }}
        <div class="card-body"> 
          <div class="form-group">
            <label for="exampleInputEmail1">District</label>
            <span class="fa fa-asterisk"></span>
            <select name="district" class="form-control">
              <option selected disabled>Select District</option>
              @foreach ($Districts as $District)
              <option value="{{ $District->id }}"{{ $assembly->district_id==$District->id?'selected': '' }}>{{ $District->code }}--{{ $District->name_e }}</option>  
              @endforeach
            </select>
          </div> 
          <div class="form-group">
            <label for="exampleInputEmail1">Assembly Code</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="code" class="form-control" placeholder="Enter Code" maxlength="5" value="{{ $assembly->code }}">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Assembly Name (English)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50" value="{{ $assembly->name_e }}">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Assembly Name (Local Language)</label>
            <span class="fa fa-asterisk"></span>
            <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50" value="{{ $assembly->name_l }}">
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

