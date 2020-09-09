@foreach ($Districts as $District)
@php
    $ZilaParishad=App\Model\ZilaParishad::where('districts_id',$District->id)->count('ward_no'); 
@endphp
 <tr>
     <td>{{ $District->states->name_e or '' }}</td>
     <td>{{ $District->code }}</td>
     <td>{{ $District->name_e }}</td>
     <td>{{ $District->name_l }}</td>
     <td>{{ $ZilaParishad }}</td>
     <td class="text-nowrap">
         <a onclick="callPopupLarge(this,'{{ route('admin.Master.districtsEdit',$District->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
         <a href="{{ route('admin.Master.districtsDelete',Crypt::encrypt($District->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
     </td>
 </tr> 
@endforeach