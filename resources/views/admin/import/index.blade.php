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
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">District</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-6">
                  <a href="#" data-table-excel="district_sample_table" onclick="callAjax(this,'{{ route('admin.import.DistrictExportSample') }}','district_form')">Sample</a> 
                </div>
                <div class="col-lg-6">
                  <a href="#"  onclick="callAjax(this,'{{ route('admin.import.DistrictImportForm') }}','district_form')">Import</a> 
                </div>
                <div class="col-lg-12" id="district_form" style="margin-top: 30px">

                </div> 
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Assembly</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-6">
                  <a href="#" data-table-excel="assembly_sample_table" onclick="callAjax(this,'{{ route('admin.import.AssemblyExportSample') }}','assembly_form')">Sample</a> 
                </div>
                <div class="col-lg-6">
                  <a href="#" onclick="callAjax(this,'{{ route('admin.import.AssemblyImportForm') }}','assembly_form')">Import</a> 
                </div>
                <div class="col-lg-12" id="assembly_form" style="margin-top: 30px">

                </div> 
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Block</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-6">
                  <a href="#" data-table-excel="block_sample_table" onclick="callAjax(this,'{{ route('admin.import.BlockExportSample') }}','block_form')">Sample</a> 
                </div>
                <div class="col-lg-6">
                  <a href="#"  onclick="callAjax(this,'{{ route('admin.import.BlockImportForm') }}','block_form')">Import</a> 
                </div>
                <div class="col-lg-12" id="block_form" style="margin-top: 30px">

                </div> 
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Village</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-6">
                  <a href="#" data-table-excel="village_sample_table" onclick="callAjax(this,'{{ route('admin.import.VillageExportSample') }}','village_form')">Sample</a> 
                </div>
                <div class="col-lg-6">
                  <a href="#"  onclick="callAjax(this,'{{ route('admin.import.VillageImportForm') }}','village_form')">Import</a>
                </div>
                <div class="col-lg-12" id="village_form" style="margin-top: 30px">

                </div> 
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Village Ward</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-6">
                  <a href="#" data-table-excel="village_ward_sample_table" onclick="callAjax(this,'{{ route('admin.import.VillageWardExportSample') }}','village_ward_form')">Sample</a> 
                </div>
                <div class="col-lg-6">
                  <a href="#"  onclick="callAjax(this,'{{ route('admin.import.VillageWardImportForm') }}','village_ward_form')">Import</a>
                </div>
                <div class="col-lg-12" id="village_ward_form" style="margin-top: 30px">

                </div> 
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Import Vote</h3>
                <div class="card-tools">
                  <a href="{{ asset('import_vote.csv') }}" class="btn btn-xs btn-warning"><i class="fa fa-download"></i> Download Sample</a>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <form action="{{ route('admin.import.importVote') }}" method="post" class="add_form" no-reset="true"> 
              <div class="card-body row"> 
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
              </form>  
            </div>
          </div> 
        </div> 
      </div> 
    </div>
  </div> 
</section>
@endsection
@push('scripts') 
<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js">
@endpush

