 
  @php
   $hotMenus =App\Helper\MyFuncs::hotMenu($menu_type_id); 
  @endphp
  @foreach($hotMenus as $hotMenu)

  <li class="nav-item d-none d-sm-inline-block">
       <a class="nav-link" href="{{ route(''.$hotMenu->url) }}">{{ $hotMenu->name }} </a>
      </li> 
   
  @endforeach 
 
 

