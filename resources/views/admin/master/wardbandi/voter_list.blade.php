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
            <th>Village</th>
            <th>Ward</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($voterLists as $voterList)
            <tr>
              <td>{{ $voterList->sr_no }}</td>
              <td>{{ $voterList->name_l }}</td>
              <td>{{ $voterList->father_name_l }}</td>
              <td>{{ $voterList->vil_name }}</td>
              <td>{{ $voterList->ward_no }}</td>
            </tr> 
          @endforeach
        </tbody>
      </table>
        
    </div>
  </div>
</div>