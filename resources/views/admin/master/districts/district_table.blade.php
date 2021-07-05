<table id="district_datatable" class="table table-striped table-hover control-label">
    <thead>
        <tr>
            <th>States</th>
            <th>Code</th>
            <th>Name (English)</th>
            <th>Name (Local Language)</th>
            <th>Total Z.P.Ward</th>
            <th>Action</th>
             
        </tr>
    </thead>
    <tbody> 
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
         <a onclick="callPopupLarge(this,'{{ route('admin.Master.DistrictsZpWard',$District->id) }}')" title="" class="btn btn-primary btn-xs" style="color: #fff">Add Z.P.Ward</a>
         <a onclick="callPopupLarge(this,'{{ route('admin.Master.districtsEdit',$District->id) }}')" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
         <a href="{{ route('admin.Master.districtsDelete',Crypt::encrypt($District->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
     </td>
 </tr> 
@endforeach
</tbody>
</table>