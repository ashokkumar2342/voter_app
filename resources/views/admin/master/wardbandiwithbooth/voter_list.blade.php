<div class="col-lg-12"> 
<div class="card card-info">
  <div class="card-header">
     <h3 class="card-title"></h3>
    </div> 
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped" id="voter_list_table">
        <thead>
          <tr>
            <th>Sr.No</th>
            <th>Name </th>
            <th>F/H Name</th>
            <th>Ward No.</th>
            <th>Booth No.</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($voterLists as $voterList)
            <tr>
              <td>{{ $voterList->sr_no }}</td>
              <td>{{ $voterList->name_l }}</td>
              <td>{{ $voterList->father_name_l }}</td>
              <td>{{ $voterList->ward_no }}</td>
              <td>{{ $voterList->Booth_No }}</td>
              <td>
                <a href="#" onclick="callAjax(this,'{{ route('admin.Master.DeleteVoter',$voterList->id) }}')" select-triger="assembly_part_select_box" success-popup="true" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
              </td>
            </tr> 
          @endforeach
        </tbody>
      </table>
        
    </div>
  </div>
</div>