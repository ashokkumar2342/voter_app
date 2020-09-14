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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#district_sample">District Sample Export</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#district_menu">District Import</a>
                                </li> 
                            </ul> 
                            <div class="tab-content">
                                <div id="district_sample" class="container tab-pane active"><br>
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
                                <div id="district_menu" class="container tab-pane fade"><br>
                                    <a href="#" id="district_button" hidden onclick="callAjax(this,'{{ route('admin.import.DistrictImportForm') }}','district_form')">click Form</a>
                                    <div id="district_form">

                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#assembly_sample">Assembly Sample Export</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#assembly_menu">Assembly Import</a>
                                </li> 
                            </ul> 
                            <div class="tab-content">
                                <div id="assembly_sample" class="container tab-pane active"><br>
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
                                <div id="assembly_menu" class="container tab-pane fade"><br>
                                    <a href="#" id="assembly_button" hidden onclick="callAjax(this,'{{ route('admin.import.AssemblyImportForm') }}','assembly_form')">click Form</a>
                                    <div id="assembly_form">
                           
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#block_sample">Block Sample Export</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#block_menu">Block Import</a>
                                </li> 
                            </ul> 
                            <div class="tab-content">
                                <div id="block_sample" class="container tab-pane active"><br>
                                    <div class="col-lg-12 table-responsive"> 
                                        <table class="table table-striped" id="block_sample_table">
                                           <thead>
                                               <tr>
                                                   <th>district_name</th>
                                                   <th>district_id</th>
                                                   <th>block_code</th>
                                                   <th>block_name_eng</th>
                                                   <th>block_name_hindi</th>
                                                   <th>total_wards</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                            @foreach ($blocks as $block) 
                                               <tr>
                                                   <td>{{ $block->name_e }}</td>
                                                   <td>{{ $block->id }}</td>
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
                                <div id="block_menu" class="container tab-pane fade"><br>
                                    <a href="#" id="block_button" hidden onclick="callAjax(this,'{{ route('admin.import.BlockImportForm') }}','block_form')">click Form</a>
                                 <div class="col-lg-12 table-responsive" id="block_form">
                           
                                  </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#village_sample">Village Sample Export</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#village_menu">Village Import</a>
                                </li> 
                            </ul> 
                            <div class="tab-content">
                                <div id="village_sample" class="container tab-pane active"><br>
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
                                <div id="village_menu" class="container tab-pane fade"><br>
                                    <a href="#" id="village_button" hidden onclick="callAjax(this,'{{ route('admin.import.VillageImportForm') }}','village_form')">click Form</a>
                                 <div class="col-lg-12 table-responsive" id="village_form">
                           
                                  </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary"> 
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#village_ward_sample">Village Ward Sample Export</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#village_ward_menu">Village Ward Import</a>
                                </li> 
                            </ul> 
                            <div class="tab-content">
                                <div id="village_ward_sample" class="container tab-pane active"><br>
                                    <div class="col-lg-12 table-responsive"> 
                                    <table class="table" id="village_ward_sample_table">
                                    <thead>
                                      <tr>
                                        <th>state_id</th>
                                        <th>state_name</th>
                                        <th>district_id</th>
                                        <th>district_name</th>
                                        <th>block_id</th>
                                        <th>block_name</th>
                                        <th>village_id</th>
                                        <th>village_name</th>
                                        <th>total_wards</th>
                                        <th>zp_ward_no</th>
                                        <th>ps_ward_noo</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($villagewards as $villageward)
                                      <tr>
                                        <td>{{ $villageward->state_id }}</td>
                                        <td>{{ $villageward->state_name }}</td>
                                        <td>{{ $villageward->district_id }}</td>
                                        <td>{{ $villageward->district_name }}</td>
                                        <td>{{ $villageward->block_id }}</td>
                                        <td>{{ $villageward->block_name }}</td>
                                        <td>{{ $villageward->village_id }}</td>
                                        <td>{{ $villageward->village_name }}</td>
                                        <td>{{ @$villageward->Total_Wards }}</td>
                                        <td></td>
                                        <td></td>
                                      </tr> 
                                      @endforeach
                                    </tbody>
                                    </table>
                                    </div> 
                                </div>
                              <div id="village_ward_menu" class="container tab-pane fade"><br>
                                    
                               <form action="{{ route('admin.import.VillageWardImportStore') }}" method="get" enctype="multipart/form-data" success-content-id="village_ward_imported_table" no-reset="true" data-table-without-pagination="village_ward_sample_datarecordtable" class="add_form">
                               <div class="row">
                               <div class="col-lg-8 form-group">
                               <label for="exampleInputFile">Import File</label>
                               <div class="input-group">
                               <div class="custom-file">
                               <input type="file" class="custom-file-input" id="exampleInputFile" name="import_file">
                               <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                               </div> 
                               </div>
                               </div> 
                               <div class="col-lg-4 form-group">
                                <input type="submit" class="btn btn-success" style="margin-top: 30px">
                               </div> 
                               </div>
                               <div class="col-lg-12 table-responsive" id="village_ward_imported_table">
                                  
                                </div> 
                               </form>
                              </div> 
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
                        "pageLength": 2,
                        "bFilter": false,
                        dom: 'Bfrtip',
                        buttons: [
                        'excel',
                        ]
                    } );
                    $('#assembly_sample_table').DataTable( {
                        "pageLength": 2,
                        "bFilter": false,
                        dom: 'Bfrtip',
                        buttons: [
                        'excel',
                        ]
                    } );
                    $('#block_sample_table').DataTable( {
                        "pageLength": 2,
                        "bFilter": false,
                        dom: 'Bfrtip',
                        buttons: [
                        'excel',
                        ]
                    } );
                    $('#village_sample_table').DataTable( {
                        "pageLength": 2,
                        "bFilter": false,
                        dom: 'Bfrtip',
                        buttons: [
                        'excel',
                        ]
                    } );
                    $('#village_ward_sample_table').DataTable( {
                        "pageLength": 2,
                        "bFilter": false,
                        dom: 'Bfrtip',
                        buttons: [
                        'excel',
                        ]
                    } );
                    $('#district_button').click();
                    $('#assembly_button').click();
                    $('#block_button').click();
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

