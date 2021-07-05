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
                <form action="{{ route('admin.VoterListMaster.store') }}" method="post" class="add_form" content-refresh="voter_list_master">
                {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Name</label>
                          <input type="text" name="voter_list_name" class="
                          form-control" maxlength="200">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Voter List Type</label>
                          <input type="text" name="voter_list_type" class="
                          form-control" maxlength="200">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Publication Year</label>
                          <input type="text" name="publication_year" class="form-control" maxlength="4" {{-- onkeypress='return event.charCode >= 48 && event.charCode <= 57' --}} >
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Date of Publication</label>
                          <input type="text" name="date_of_publication" class="form-control" maxlength="20">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Base Year</label>
                          <input type="text" name="base_year" class="form-control"
                          maxlength="4">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Base Date</label>
                          <input type="text" name="base_date" class="form-control"
                          maxlength="20">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks1</label>
                          <input type="text" name="remarks1" class="form-control" maxlength="100">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks2</label>
                          <input type="text" name="remarks2" class="form-control" maxlength="100">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="exampleInputEmail1">Remarks3</label>
                          <input type="text" name="remarks3" class="form-control" maxlength="100">
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
            <div class="table-responsive col-lg-12"> 
            <table class="table table-striped table-bordered" id="voter_list_master">
               <thead>
                 <tr>
                   <th class="text-nowrap">Voter List Name</th>
                   <th class="text-nowrap">Voter List Type</th>
                   <th class="text-nowrap">Year Publication</th>
                   <th class="text-nowrap">Date Publication</th>
                   <th class="text-nowrap">Year Base</th>
                   <th class="text-nowrap">Date Base</th>
                   <th class="text-nowrap">Remarks</th>
                   <th class="text-nowrap">Action</th>
                 </tr>
               </thead>
               <tbody>
                @foreach ($VoterListMasters as $VoterListMaster)
                 <tr style="{{ $VoterListMaster->status==1?'background-color: #95e49b':'' }}">
                   <td>{{ $VoterListMaster->voter_list_name }}</td>
                   <td>{{ $VoterListMaster->voter_list_type }}</td>
                   <td>{{ $VoterListMaster->year_publication }}</td>
                   <td>{{ $VoterListMaster->date_publication }}</td>
                   <td>{{ $VoterListMaster->year_base }}</td>
                   <td>{{ $VoterListMaster->date_base }}</td>
                   <td>{{ $VoterListMaster->remarks1 }}</td>
                   <td class="text-nowrap">
                    @if ($VoterListMaster->status==1)
                     <a href="{{ route('admin.VoterListMaster.default',$VoterListMaster->id) }}" title="" class="btn btn-success btn-xs">Default</a>
                     @else
                     <a href="{{ route('admin.VoterListMaster.default',$VoterListMaster->id) }}" title="" class="btn btn-default btn-xs">Default</a> 
                    @endif
                    <a href="#" title="Edit" class="btn btn-xs btn-info" onclick="callPopupLarge(this,'{{ route('admin.VoterListMaster.edit',$VoterListMaster->id) }}')"><i class="fa fa-edit"></i></a>
                   </td>
                 </tr>
                 @endforeach
               </tbody>
             </table>
           </div>
             </div> 
        </div>
    </div> 
</section>
@endsection 
@push('scripts')  
 <script type="text/javascript">
     $(document).ready(function(){
        $('#voter_list_master').DataTable();
    });
</script> 
@endpush
  



