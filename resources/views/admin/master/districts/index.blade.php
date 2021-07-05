@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Districts</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary"> 
                            <form action="{{ route('admin.Master.districtsStore') }}" method="post" class="add_form" content-refresh="district_datatable">
                                {{ csrf_field() }}
                                <div class="card-body row"> 
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputEmail1">Districts Code</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code"maxlength="5">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputPassword1">Districts Name (English)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_english" id="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50">
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label for="exampleInputPassword1">Districts Name (Local Language)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_local_language" id="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50">
                                    </div> 
                                </div> 
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-primary" id="district_table"> 
                             <table id="district_datatable" class="table table-striped table-hover control-label">
                                 <thead>
                                     <tr> 
                                         <th>Code</th>
                                         <th>Name (English)</th>
                                         <th>Name (Local Language)</th> 
                                         <th>Action</th>
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                   @foreach ($Districts as $District)
                                    
                                    <tr>
                                         
                                        <td>{{ $District->code }}</td>
                                        <td>{{ $District->name_e }}</td>
                                        <td>{{ $District->name_l }}</td>
                                         
                                        <td class="text-nowrap"> 
                                            <a onclick="callPopupLarge(this,'{{ route('admin.Master.districtsEdit',$District->id) }}')" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.Master.districtsDelete',Crypt::encrypt($District->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
    @push('scripts')
    <script type="text/javascript"> 
        $('#district_datatable').DataTable();
    </script>
    @endpush 

