<table id="block_datatable" class="table table-striped table-hover">
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
       @foreach ($BlocksMcs as $BlockMc)
        
        <tr>
             
            <td>{{ $BlockMc->district->name_e or '' }}</td>
            <td>{{ $BlockMc->code }}</td>
            <td>{{ $BlockMc->name_e }}</td>
            <td>{{ $BlockMc->name_l }}</td>
             
            <td class="text-nowrap"> 
                <a onclick="callPopupLarge(this,'{{ route('admin.Master.BlockMCSEdit',$BlockMc->id) }}')" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                <a href="{{ route('admin.Master.BlockMCSDelete',Crypt::encrypt($BlockMc->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
            </td>
        </tr> 
       @endforeach
    </tbody>
</table>