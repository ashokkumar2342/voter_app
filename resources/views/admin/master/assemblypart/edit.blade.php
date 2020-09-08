<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Add Part No.</h4>
      <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.Master.AssemblyPart.store') }}" method="post" class="add_form" content-refresh="district_table" button-click="btn_close">
                                {{ csrf_field() }}
                                <div class="card-body"> 
                                     <input type="hidden" name="Assembly" value="{{ @$assembly_id}}">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">How Many Part No. To Create </label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="part_no" class="form-control" placeholder="Enter Code" maxlength="5">
                                    </div> 
                                    
                                </div> 
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                </div>
                            </form>
    </div>
  </div>
</div>

