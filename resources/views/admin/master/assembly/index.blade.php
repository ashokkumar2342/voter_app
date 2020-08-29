@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Assembly</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <form action="{{ route('admin.Master.Assembly.store') }}" method="post" class="add_form" content-refresh="district_table">
                                {{ csrf_field() }}
                                <div class="card-body"> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">District</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="district" class="form-control">
                                            <option selected disabled>Select District</option>
                                            @foreach ($Districts as $District)
                                            <option value="{{ $District->id }}">{{ $District->code }}--{{ $District->name_e }}</option>  
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Assembly Code</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="code" class="form-control" placeholder="Enter Code" maxlength="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Assembly Name (English)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Assembly Name (Local Language)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div> 
                                        </div>
                                    </div> 
                                </div> 
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary table-responsive"> 
                             <table id="district_table" class="table table-striped table-hover control-label">
                                 <thead>
                                     <tr>
                                          
                                         <th>District</th>
                                         <th>Code</th>
                                         <th>Name (English)</th>
                                         <th>Name (Local Language)</th>
                                         <th>Action</th>
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($assemblys as $assembly)
                                     <tr>
                                          
                                         <td>{{ $assembly->district->name_e or '' }}</td>
                                         <td>{{ $assembly->code }}</td>
                                         <td>{{ $assembly->name_e }}</td>
                                         <td>{{ $assembly->name_l }}</td>
                                         <td class="text-nowrap">
                                             <a onclick="callPopupLarge(this,'{{ route('admin.Master.Assembly.edit',$assembly->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="{{ route('admin.Master.Assembly.delete',$assembly->id) }}" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                         </td>
                                     </tr> 
                                    @endforeach
                                 </tbody>
                             </table>
                        </div> 
                    </div> 
                </div>
            </div> 
        </div> 
    </section>
    @endsection
    <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

