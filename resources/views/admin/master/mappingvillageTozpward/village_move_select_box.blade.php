<div class="col-12">
<div class="form-group">
  <label>Village</label>
  <select class="duallistbox" multiple="multiple" name="village[]">
    @foreach ($villages as $village)
       <option value="{{ $village->id }}"{{ in_array($village->id,$village_id)?'selected':'' }}>{{ $village->name_e }}</option>
    @endforeach 
  </select>
</div>
<!-- /.form-group -->
</div>