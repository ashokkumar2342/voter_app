@php
	$counter = 0;
@endphp
@foreach ($voterReports as $voterReport) 
	<table width="100%">
		<tbody>
			<tr>
				<td style="text-align:center;font-size:20px;word-spacing:5px"><b>{{$slipheader}}</b></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tbody>
			<tr>
				<td style="width: 100%; text-align:center;font-size:18px;word-spacing:5px"><b>Voter Slip</b></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tbody>
			<tr style="height: 13px;">
				<td style="width: 80px; height: 13px;font-size:18px;word-spacing:5px;">वार्ड न० :</td>
				<td style="width: 74px; height: 13px;font-size:18px;word-spacing:5px"><b>{{$wardno}}</b></td>
				<td style="width: 93px; height: 13px;font-size:18px;word-spacing:5px">Part No. :</td>
				<td style="width: 249px; height: 13px;font-size:18px;word-spacing:5px"><b>{{$voterReport->part_no}}</b></td>
				<td style="width: 91px; height: 67px;" rowspan="4">
@php	
$dirpath = '/app/vimage/'.$voterReport->assembly_id.'/'.$voterReport->assembly_part_id;
$name =$voterReport->id;
$image  =\Storage_path($dirpath.'/'.$name.'.jpg');
@endphp
					<img src="{{ $image }}" alt="" width="130px" height="130px">
				</td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">नाम</td>
				<td style="font-size:18px;word-spacing:5px" colspan="3"><b>{{ $voterReport->name_l }}&nbsp;</b></td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">लिंग</td>
				<td style="font-size:18px;word-spacing:5px"><b>{{$voterReport->genders_l}}</b></td>
				<td style="font-size:18px;word-spacing:5px">EPIC No. :</td>
				<td style="font-size:18px;word-spacing:5px"><b>{{ $voterReport->voter_card_no }}</b></td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">{{ $voterReport->vrelation }}</td>
				<td style="font-size:18px;word-spacing:5px" colspan="3"><b>{{ $voterReport->father_name_l }}&nbsp;</b></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tbody>
			<tr>
				<td style="width: 100%; font-size:18px;word-spacing:5px">मतदाता क्रमांक संख्या : <b>{{ $voterReport->print_sr_no }}</b></td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">Polling Station No. and Name : <b>{{ $voterReport->boothno }} -  {{ $voterReport->pb_name }}</b> </td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">Poll Date, Day and Time : <b>{{ $polldatetime->polling_day_time_l }}</b></td>
			</tr>
			<tr>
				<td>Note: 1 This Voter Slip can also be produced as an identification document</td>
			</tr>
			<tr>
				<td>Note: 2 Bringing this voter slip to the Polling Station is however not compulsory, it is issued only as convenience to electors</td>
			</tr>
			<tr>
				<td>Note: 3 If this voter slip does not have a photograph or it has wrong particulars or photograph, the voter can still be allowed to vote base on alternate identity documents permitted by the State Election Commission, Haryana</td>
			</tr>
			<tr>
				<td>Note: 4 Last one hour of poll is reserved for Covid-19 patient.</td>
			</tr>
		</tbody>
	</table>
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 20%;font-size: 18px"></td>
				<td style="width: 20%">&nbsp;</td> 
				<td style="width: 40%;text-align:center" align="center">
				@php 
				$image  =\Storage_path('/app'.$polldatetime->signature);
				@endphp
					<img src="{{ $image }}" alt="" height="50px" align="center">
				</td>
			</tr>
			<tr>
				<td style="font-size: 14px">&nbsp;Date : {{date('d-m-Y')}}</td>
				<td>&nbsp;</td> 
				<td style="font-size: 14px" align="center">{{ $blockMcs[0]->stamp_l1 }}<br>{{ $blockMcs[0]->stamp_l2 }}</td>
			</tr>
		</tbody>
	</table> 
	<hr style="height:2px;border-width:0;color:black;background-color:black;margin-top:0px">
	@php
		$counter++;
		if($counter==2){$counter=0;
	@endphp	

		<pagebreak>

	@php
		}

	@endphp 
@endforeach
