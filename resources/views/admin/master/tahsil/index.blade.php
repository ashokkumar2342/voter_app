@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Add Tahsil</h3>
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
                            <form action="{{ route('admin.Master.tahsil.store') }}" method="post" class="add_form" no-reset="true" select-triger="district_select_box" reset-input-text="code,name_english,name_local_language,block_mc_type,ps_ward">
                                {{ csrf_field() }} 
                                    <div class="row">  
                                    <div class="col-lg-3 form-group">
                                        <label for="exampleInputEmail1">District</label>
                                        <span class="fa fa-asterisk"></span>
                                         <select id="district_select_box" name="district" class="form-control" onchange="callAjax(this,'{{ route('admin.Master.tahsilTable') }}','tahsil_table')">
                                             <option selected disabled>Select District</option>
                                             @foreach ($Districts as $District) 
                                             <option value="{{ $District->id }}">{{ $District->name_e }}</option> 
                                              @endforeach 
                                         </select>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="exampleInputEmail1">Tahsil Code</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code" maxlength="5">
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="exampleInputPassword1">Tahsil Name(English)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_english" id="name_english" class="form-control" placeholder="Enter Name (English)" maxlength="50">
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <label for="exampleInputPassword1">Tahsil Name(Local Lang)</label>
                                        <span class="fa fa-asterisk"></span>
                                        <input type="text" name="name_local_language" id="name_local_language" class="form-control" placeholder="Enter Name (Local Language)" maxlength="50">
                                    </div> 
                                </div> 
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form> 
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-primary table-responsive" id="tahsil_table"> 
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
        $('#btn_click_by_form').click();
        $('#district_table').DataTable();
    </script>
    @endpush 

