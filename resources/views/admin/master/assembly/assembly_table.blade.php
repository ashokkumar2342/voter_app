@foreach ($assemblys as $assembly)
@php
    $part_no=App\Model\AssemblyPart::where('assembly_id',$assembly->id)->count('part_no'); 
@endphp
 <tr>
      
     <td>{{ $assembly->district->name_e or '' }}</td>
     <td>{{ $assembly->code }}</td>
     <td>{{ $assembly->name_e }}</td>
     <td>{{ $assembly->name_l }}</td>
     <td>{{ $part_no }}</td>
     <td class="text-nowrap">
         <a onclick="callPopupLarge(this,'{{ route('admin.Master.AssemblyPart.edit',$assembly->id) }}')" title="" class="btn btn-primary btn-xs" style="color: #fff">Add Part</a>
         <a onclick="callPopupLarge(this,'{{ route('admin.Master.Assembly.edit',$assembly->id) }}')" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
         <a href="{{ route('admin.Master.Assembly.delete',$assembly->id) }}" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
     </td>
 </tr> 
@endforeach