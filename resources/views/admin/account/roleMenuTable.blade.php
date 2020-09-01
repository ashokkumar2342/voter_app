<div class="row"> 
  <div class="col-lg-3"> 
    {{ Form::label('sub_menu','Menu',['class'=>' control-label']) }} <br>
    <select class="selectpicker multiselect" multiple data-live-search="true" name="sub_menu[]">
      @foreach ($menus as $menu) 
      <optgroup label="{{ $menu->name }}"> 
        @foreach ($subMenus as $subMenu)
        @if ($menu->id==$subMenu->menu_type_id )
        <option value="{{ $subMenu->id }}" {{ in_array($subMenu->id, $datas)?'selected':'' }} >{{ $subMenu->name }}</option> 
        @endif
        @endforeach 
      </optgroup>
      @endforeach                                    
    </select> 
  </div>
  <div class="col-md-3" style="margin-top: 30px"> 
    <button type="submit"  class="btn btn-success form-control">Save</button> 
  </div>
</form>
<div class="col-lg-6" style="margin-top: 30px">
   <form action="{{ route('admin.account.default.user.role.report.generate',Crypt::encrypt($id)) }}" method="post" target="blank">
  {{ csrf_field() }} 
    <div class="icheck-primary d-inline">
      <input type="radio" id="radioPrimary1" name="optradio" value="selected" checked>
      <label for="radioPrimary1">Only Selected</label>  
    </div> 
    <div class="icheck-primary d-inline">
      <input type="radio" id="radioPrimary2" name="optradio" value="all" checked>
      <label for="radioPrimary2">All</label>  
    </div>
    <input type="submit" value="PDF" class="btn btn-primary" style="width: 200px;margin-left: 10px">
 </form>
  </div>
 </div>

@include('admin.account.report.result')

