@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Voter List Download</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <table class="table-striped table-bordered table">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Block MC</th>
                                    <th>Village</th>
                                    <th>Ward</th>
                                    <th>Voter List Master</th>
                                    <th>Report Type</th>
                                    <th>File With Photo</th>
                                    <th>File Without Photo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voterlistprocesseds as $voterlistprocessed)
                                <tr>
                                    <td></td>
                                    <td>{{ $voterlistprocessed->district->name_e or '' }}</td>
                                    <td>{{ $voterlistprocessed->Blocks->name_e or '' }}</td>
                                    <td>{{ $voterlistprocessed->Villages->name_e or '' }}</td>
                                    <td>{{ $voterlistprocessed->WardVillages->ward_no or '' }}</td>
                                    <td>{{ $voterlistprocessed->voter_list_master_id or '' }}</td>
                                    <td>{{ $voterlistprocessed->report_type or '' }}</td>
                                    <td>
                                    <a target="_blank" href="{{ route('admin.voter.VoterListDownloadPDF',[$voterlistprocessed->id,'p']) }}" title="">Download</a>
                                    </td>
                                    <td>
                                    <a target="_blank" href="{{ route('admin.voter.VoterListDownloadPDF',[$voterlistprocessed->id,'w']) }}" title="">Download</a>
                                    </td>
                                </tr>                                     
                                @endforeach
                            </tbody>
                        </table>    

                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



