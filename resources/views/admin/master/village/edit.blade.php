<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Add Ward</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.village.store',$village->id) }}" method="post" class="add_form" no-reset="true" select-triger="block_select_box" button-click="btn_close">
      {{ csrf_field() }}
      <div class="card-body">
          <div class="row"> 
          <div class="col-lg-4 form-group">
              <label for="exampleInputEmail1">States</label>
              <span class="fa fa-asterisk"></span>
              <select name="states" class="form-control" onchange="callAjax(this,'{{ route('admin.Master.stateWiseDistrict') }}','district_select_box_edit')">
                  <option selected disabled>Select States</option>
                  @foreach ($States as $State)
                  <option value="{{ $State->id }}"{{-- {{ $State->id==$village->states_id?'selected':'' }} --}}>{{ $State->code }}--{{ $State->name_e }}</option>  
                  @endforeach
              </select>
          </div>
          <div class="col-lg-4 form-group">
              <label for="exampleInputEmail1">District</label>
              <span class="fa fa-asterisk"></span>
              <select name="district" class="form-control" id="district_select_box_edit" onchange="callAjax(this,'{{ route('admin.Master.DistrictWiseBlock') }}','block_select_box_edit')">
                  <option selected disabled>Select District</option>
              </select>
          </div>
          <div class="col-lg-4 form-group">
              <label for="exampleInputEmail1">Block MCS</label>
              <span class="fa fa-asterisk"></span>
              <select name="block_mcs" class="form-control" id="block_select_box_edit">
                  <option selected disabled>Select Block MCS</option>
                   
              </select>
          </div> 
          <div class="col-lg-4 form-group">
              <label for="exampleInputEmail1">Village Code</label>
              <span class="fa fa-asterisk"></span>
              <input type="text" name="code" class="form-control" placeholder="Enter Code" maxlength="5" value="{{ $village->code }}">
          </div>
          <div class="col-lg-4 form-group">
              <label for="exampleInputPassword1">Village Name (English)</label>
              <span class="fa fa-asterisk"></span>
              <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50" value="{{ $village->name_e }}">
          </div>
          <div class="col-lg-4 form-group">
              <label for="exampleInputPassword1">Village Name (Local Language)</label>
              <span class="fa fa-asterisk"></span>
              <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50" value="{{ $village->name_l }}">
          </div> 
          </div> 
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success form-control">Update</button>
           
        </div>
      </form>
    </div>
  </div>
</div>

