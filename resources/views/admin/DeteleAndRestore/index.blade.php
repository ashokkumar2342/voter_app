@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Delete And Restore</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <button type="button" class="btn btn-default form-control" style="width: 200px" onclick="callPopupLarge(this,'{{ route('admin.voter.DeteleAndRestoreSearch') }}')"> Search &nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i></button>
                </ol>
            </div>
        </div> 
        <button type="hidden" hidden="" id="btn_click_by_delete_form" class="hidden remove_weight_button" select-triger="district_select_box" onclick="callAjax(this,'{{ route('admin.voter.DeteleAndRestoreForm') }}','delete_form')">Click form</button>
        <div id="delete_form">
            
        </div>
    </div>
    </section>
    @endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
    
    $("#btn_click_by_delete_form").click();
        
    
    });

</script>

