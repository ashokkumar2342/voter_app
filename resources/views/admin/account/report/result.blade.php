 
<div class="col-lg-12" style="margin-top:10px;">
        @php
          $role=App\Model\Role::find($id)
        @endphp
        Role : <span style="color:#d02ee7 ;margin-bottom: 10px"><b>{{ $role->name or '' }}</b></span>  
  <table class="table table-condensed "id="menu_role_table" style="width: 100%">
    <thead>
    
      <tr>
        <th>Sub Menu Name</th>
        <th>Main Menu Name</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($menus as $menu)
      <tr>
        <td></td>
        <td>{{ $menu->name }}</td>
        <td></td>
      </tr>
      @foreach ($subMenus as $subMenu)
         @if ($menu->id==$subMenu->menu_type_id )
      <tr style="{{ in_array($subMenu->id, $datas)?'background-color: #28a745':'background-color: #dc3545' }}">
        <td>{{ $subMenu->name }}</td>
        <td></td>
            
         <td>@if ( in_array($subMenu->id, $datas)) Yes @else  No @endif  </td> 
    
      </tr>
       @endif 
       @endforeach  
       @endforeach 
    </tbody>
  </table>
</div>