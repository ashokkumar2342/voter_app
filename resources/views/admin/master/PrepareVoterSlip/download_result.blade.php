<div class="row">
    <div class="col-lg-12">
        <table class="table-striped table-bordered table">
            <thead>
                <tr>
                    
                    <th>Village</th>
                    <th>Ward</th> 
                    <th>Booth</th> 
                    <th class="text-nowrap">Download</th>
                     
                     
                </tr>
            </thead>
            <tbody>
                @foreach ($VoterSlipProcesseds as $VoterSlipProcessed)
                <tr> 
                    <td>{{ $VoterSlipProcessed->Villages->name_e or '' }}</td>
                    <td>{{ $VoterSlipProcessed->WardVillages->ward_no or '' }}</td> 
                    <td>{{ $VoterSlipProcessed->booths->booth_no or '' }}</td> 
                    
                    <td>
                    @if ($VoterSlipProcessed->status==1)
                    <a target="_blank" href="{{ route('admin.prepare.voter.slip.result.download',$VoterSlipProcessed->id) }}" title="">Download</a>  
                    @else
                        Pending
                    @endif
                    </td>
                    
                </tr>                                     
                @endforeach
            </tbody>
        </table>
    </div>
</div>    