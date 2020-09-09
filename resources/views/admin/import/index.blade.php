@extends('admin.layout.base')
@push('links')
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">    
@endpush
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Import Export</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                 <ul class="nav nav-tabs" role="tablist">
                     <li class="nav-item">
                       <a class="nav-link active" data-toggle="tab" href="#home">District Sample Export</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#menu1">District Import</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#menu2">Assembly Sample Export</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#menu3">Assembly Import</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#menu4">Village Sample Export</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#menu5">Village Import</a>
                     </li>
                   </ul>

                   <!-- Tab panes -->
                   <div class="tab-content">
                     <div id="home" class="container tab-pane active"><br>
                      <div class="col-lg-12 table-responsive"> 
                       <table class="table table-striped" id="district_sample_table">
                           <thead>
                               <tr>
                                   <th>state_name</th>
                                   <th>state_id</th>
                                   <th>district_code</th>
                                   <th>district_name_eng</th>
                                   <th>district_name_hindi</th>
                                   <th>total_zp_wards</th>
                               </tr>
                           </thead>
                           <tbody>
                            @foreach ($Districts as $District) 
                               <tr>
                                   <td>{{ $District->name_e }}</td>
                                   <td>{{ $District->id }}</td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                               </tr>
                            @endforeach
                           </tbody>
                       </table>
                      </div> 
                     </div>
                     <div id="menu1" class="container tab-pane fade"><br>
                       <a href="#" id="district_button" hidden onclick="callAjax(this,'{{ route('admin.import.DistrictImportForm') }}','district_form')">click Form</a>
                       <div id="district_form">
                           
                       </div>
                     </div>
                     <div id="menu2" class="container tab-pane fade"><br>
                      <div class="col-lg-12 table-responsive">   
                       <table class="table table-striped" id="assembly_sample_table">
                           <thead>
                               <tr>
                                   <th>district_name</th>
                                   <th>district_id</th>
                                   <th>assembly_code</th>
                                   <th>assembly_name_eng</th>
                                   <th>assembly_name_hindi</th>
                                   <th>total_parts</th>
                               </tr>
                           </thead>
                           <tbody>
                            @foreach ($assemblys as $assembly) 
                               <tr>
                                   <td>{{ $assembly->name_e }}</td>
                                   <td>{{ $assembly->id }}</td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                               </tr>
                            @endforeach
                           </tbody>
                       </table>
                      </div> 
                     </div>
                     <div id="menu3" class="container tab-pane fade"><br>
                       <a href="#" id="assembly_button" hidden onclick="callAjax(this,'{{ route('admin.import.AssemblyImportForm') }}','assembly_form')">click Form</a>
                       <div id="assembly_form">
                           
                       </div>
                     </div>
                     <div id="menu4" class="container tab-pane fade"><br>
                      <div class="col-lg-12 table-responsive">   
                       <table class="table table-striped" id="village_sample_table">
                           <thead>
                               <tr>
                                   <th>state_name</th>
                                   <th>state_Id</th>
                                   <th>district_name</th>
                                   <th>district_id</th>
                                   <th>block_name</th>
                                   <th>block_id</th>
                                   <th>village_code</th>
                                   <th>village_name_eng</th>
                                   <th>village_name_hindi</th>
                                   <th>total_wards</th>
                               </tr>
                           </thead>
                           <tbody>
                            @foreach ($villages as $villages) 
                               <tr>
                                   <td>{{ $villages->state_name }}</td>
                                   <td>{{ $villages->state_id }}</td>
                                   <td>{{ $villages->district_name }}</td>
                                   <td>{{ $villages->district_id }}</td>
                                   <td>{{ $villages->block_name }}</td>
                                   <td>{{ $villages->block_id }}</td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                               </tr>
                            @endforeach
                           </tbody>
                       </table>
                   </div>
                     </div>
                     <div id="menu5" class="container tab-pane fade"><br>
                       <a href="#" id="village_button" hidden onclick="callAjax(this,'{{ route('admin.import.VillageImportForm') }}','village_form')">click Form</a>
                       <div class="col-lg-12 table-responsive" id="village_form">
                           
                       </div>
                     </div>
                   </div>
                 </div>
            </div> 
        </div> 
    </section>
@endsection
@push('scripts')
<script> 
$(document).ready(function() {
 $('#district_sample_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
              'csv', 'excel','print'
        ]
    } );
 $('#assembly_sample_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
              'csv', 'excel','print'
        ]
    } );
 $('#village_sample_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
              'csv', 'excel','print'
        ]
    } );
 $('#district_button').click();
 $('#assembly_button').click();
 $('#village_button').click();
} );
</script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js">
@endpush

