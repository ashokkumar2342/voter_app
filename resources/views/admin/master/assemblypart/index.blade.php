@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Assembly Part</h3>
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
                            <form action="{{ route('admin.Master.AssemblyPart.store') }}" method="post" class="add_form" content-refresh="district_table">
                                {{ csrf_field() }}
                                <div class="card-body"> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Assembly</label>
                                        <span class="fa fa-asterisk"></span>
                                        <select name="Assembly" class="form-control">
                                            <option selected disabled>Select Assembly</option>
                                            @foreach ($assemblys as $assembly)
                                            <option value="{{ $assembly->id }}">{{ $assembly->code }}--{{ $assembly->name_e }}</option>  
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">How Many Part No. To Create </label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="part_no" class="form-control" placeholder="Enter Code" maxlength="5">
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
                                          
                                         <th>Assembly</th>
                                         <th>Part No.</th> 
                                         <th>Action</th>
                                          
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($assemblyParts as $assemblyPart)
                                     <tr>  
                                         <td>{{ $assemblyPart->assembly->name_e or '' }}</td>
                                         <td>{{ $assemblyPart->part_no }}</td>
                                          
                                         <td class="text-nowrap">
                                             <a onclick="callPopupLarge(this,'{{ route('admin.Master.Assembly.edit',$assemblyPart->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                             <a href="{{ route('admin.Master.AssemblyPart.delete',$assemblyPart->id) }}" title="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
    @push('links')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
 <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">
     $(document).ready(function(){
        $('#district_table').DataTable();
    });
</script> 
@endpush

