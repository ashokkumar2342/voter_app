<table id="block_datatable" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>States</th>
            <th>District</th>
            <th>Code</th>
            <th>Name (English)</th>
            <th>Name (Local Language)</th>
            <th>Block MSC Type</th>
            <th>Total P.S.Ward</th>
            <th>Action</th>
             
        </tr>
    </thead>
    <tbody>
       @foreach ($BlocksMcs as $BlockMc)
       @php
           $psward=App\Model\WardPanchayat::where('blocks_id',$BlockMc->id)->count('ward_no'); 
       @endphp
        <tr>
            <td>{{ $BlockMc->states->name_e or '' }}</td>
            <td>{{ $BlockMc->district->name_e or '' }}</td>
            <td>{{ $BlockMc->code }}</td>
            <td>{{ $BlockMc->name_e }}</td>
            <td>{{ $BlockMc->name_l }}</td>
            <td>{{ $BlockMc->BlockMcTypes->block_mc_type_e or ''}}</td>
            <td>{{ $psward }}</td>
            <td class="text-nowrap">
                <a onclick="callPopupLarge(this,'{{ route('admin.Master.BlockMCSpsWard',$BlockMc->id) }}')" title="" class="btn btn-primary btn-xs" style="color: #fff">Add S.P.Ward</a>
                <a onclick="callPopupLarge(this,'{{ route('admin.Master.BlockMCSEdit',$BlockMc->id) }}')" title="" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                <a href="{{ route('admin.Master.BlockMCSDelete',Crypt::encrypt($BlockMc->id)) }}" onclick="return confirm('Are you sure you want to delete this item?');"  title="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
            </td>
        </tr> 
       @endforeach
    </tbody>
</table>