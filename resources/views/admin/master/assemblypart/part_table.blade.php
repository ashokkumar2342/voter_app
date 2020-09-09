@foreach ($assemblyParts as $assemblyPart)
 <tr>  
     <td>{{ $assemblyPart->assembly->name_e or '' }}</td>
     <td>{{ $assemblyPart->part_no }}</td>
      
     <td class="text-nowrap">
         {{-- <a onclick="callPopupLarge(this,'{{ route('admin.Master.AssemblyPart.edit',$assemblyPart->id) }}')" title="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> --}}
         <a href="{{ route('admin.Master.AssemblyPart.delete',$assemblyPart->id) }}" title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
     </td>
 </tr> 
@endforeach