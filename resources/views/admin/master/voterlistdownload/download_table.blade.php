<div class="row">
    <div class="col-lg-12">
        <table class="table-striped table-bordered table">
            <thead>
                <tr>
                    
                    <th>Village</th>
                    <th>Ward</th> 
                    <th>Booth</th> 
                    <th>Report Type</th>
                    <th class="text-nowrap">Download With Photo</th>
                    <th class="text-nowrap">Download Without Photo</th>
                    <th class="text-nowrap">Download Annexure-A</th>
                     
                </tr>
            </thead>
            <tbody>
                @foreach ($voterlistprocesseds as $voterlistprocessed)
                <tr> 
                    <td>{{ $voterlistprocessed->Villages->name_e or '' }}</td>
                    <td>{{ $voterlistprocessed->WardVillages->ward_no or '' }}</td> 
                    <td>{{ $voterlistprocessed->booths->booth_no or '' }}{{ $voterlistprocessed->booths->booth_no_c or '' }}</td> 
                    <td>{{ $voterlistprocessed->report_type or '' }}</td>
                    <td>
                    @if ($voterlistprocessed->status==1)
                    <a target="_blank" href="{{ route('admin.voter.VoterListDownloadPDF',[$voterlistprocessed->id,'p']) }}" title="">Download</a>  
                    @else
                        Pending
                    @endif
                    </td>
                    <td>
                    @if ($voterlistprocessed->status==1)
                    <a target="_blank" href="{{ route('admin.voter.VoterListDownloadPDF',[$voterlistprocessed->id,'w']) }}" title="">Download</a>  
                    @else
                        Pending
                    @endif
                    </td>
                    <td>
                    @if ($voterlistprocessed->status==1)
                    <a target="_blank" href="{{ route('admin.voter.VoterListDownloadPDF',[$voterlistprocessed->id,'h']) }}" title="">Download</a>  
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