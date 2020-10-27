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
                <h3>Report</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 form-group">
                    <label>Report Type</label>
                    <select name="report_type_id" id="report_type_id" class="form-control">
                      <option selected disabled>Select Report Type</option>
                      @foreach ($reportTypes as $reportType)
                      <option value="{{ $reportType->id }}">{{ $reportType->name }}</option>
                      @endforeach 
                    </select> 
                  </div>
                  <div class="col-lg-6 form-group">
                    <button type="button" data-table-excel-2="village_ward_sample_table" class="btn btn-primary form-control" onclick="callAjax(this,'{{ route('admin.report.ReportGenerate') }}'+'?report_type_id='+$('#report_type_id').val(),'result_data')">Take Result Excel</button> 
                  </div>
                  <div class="col-lg-6 form-group">
                    <a onclick="PdfGenerate()" id="download_with_poto" class="btn btn-warning form-control" target="blank">Take Result PDF</a> 
                  </div> 
                 </div>
                 <div class="col-lg-12" id="result_data">
                     
                 </div>  
            </div> 
        </div>
    </div> 
</section>
@endsection
@push('scripts')
<script type="text/javascript">
  function PdfGenerate() {

    $('#download_with_poto').attr('href','{{ route('admin.report.ReportGeneratePDF') }}'+'?report_type_id='+$('#report_type_id').val()); 
  }
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


