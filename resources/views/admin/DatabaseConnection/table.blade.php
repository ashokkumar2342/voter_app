@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Tables</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
             <a href="{{ route('admin.database.conection.getTable') }}" title="Refresh" class="btn btn-xs"><i class="fas fa-2x fa-sync-alt"></i></a>  
                </ol>
            </div>
        </div> 
         <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.database.conection.tableRecordStore') }}" method="post" class="add_form">
                {{ csrf_field() }} 
                <div class="row"> 
                     <table class="table" id="tableid">
                         <thead>
                             <tr>
                                  
                             
                                 <th>
                                     <div class="icheck-primary d-inline">
                                     <input type="checkbox" id="all_check" class="checked_all">
                                     <label for="all_check" class="checked_all">All</label>
                                 </th>
                                 <th>Tables</th>
                                 <th>Total Records</th>
                                 <th>Import</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                            @php
                            $totalImport =Illuminate\Support\Facades\DB::select(DB::raw("SELECT `a`.code, `ap`.`part_no`, Count(*) as `tcount`
                            FROM `voters` `v`
                            Inner Join `assemblys` `a` on `a`.`id` = `v`.`assembly_id`
                            inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Group By `a`.code, `ap`.`part_no`"));
                            @endphp
                            @foreach ($datas as $key => $data)
                            @php
                                 $counts =Illuminate\Support\Facades\DB::connection('sqlsrv')->table($data->TABLE_NAME)->count(); 
                             @endphp 
                             <tr style="">
                                 <td>
                                    <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="table[]" value="{{ $data->TABLE_NAME }}" id="{{ $data->TABLE_NAME }}"  class="checkbox">
                                     <label for="{{ $data->TABLE_NAME }}" class="checkbox"></label>
                                     </div>
                                     <input type="hidden" name="database_name" value="{{ $data->TABLE_CATALOG }}">
                                 </td>
                                 <td>{{ $data->TABLE_NAME }}</td>
                                 <td>{{ $counts }}</td>
                                 <td id="1_{{ $data->TABLE_NAME }}">
                                   <span id="count_{{ $data->TABLE_NAME }}">{{ $totalImport[$key]->tcount or ''}}</span>  </td>
                                 <td>
                                    @if (isset($totalImport[$key]->tcount)) 
                                    <a href="{{ route('admin.database.conection.processDelete',$data->TABLE_NAME) }}" title="Delete Records" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                    <div class="col-lg-12 form-group">
                        <button type="submit" class="btn btn-primary form-group form-control" >Transfer</button>
                    </div>
                </div>
            </form>
             <div class="form-group" id="process">
                
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
    
    // setInterval(statusbarStart,5000);
    
    // function statusbarStart() {
    //     $.ajax({
    //         {{-- url: '{{ route('admin.database.conection.process') }}', --}}
    //         type: 'GET',
            
    //     })
    //     .done(function(response) {
    //        $('#process').html(response)
    //     })
    //     .fail(function() {
    //         console.log("error");
    //     })
    //     .always(function() {
    //         console.log("complete");
    //     });
        
    //   {{-- callAjax(this,'{{ route('admin.database.conection.process') }}','process')   --}}
       
    // }
    //  setInterval(statusbarStart,1000);

    //  $(document).ready(function(){ 
    //     function statusbarStart(){
    //       $.get('file.txt', function(data) {
    
    //     });  
    //     }
        
    // });
 
    
</script> 
@endpush
      
 

