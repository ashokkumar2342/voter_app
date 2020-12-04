@php
	$counter = 0;
@endphp
@foreach ($voterReports as $voterReport) 
	<table width="100%">
		<tbody>
			<tr style="height: 18px;">
				<td style="text-align:center;font-size:22px;word-spacing:5px"><b>General Election to the नगर पालका झजर - 2016</b></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tbody>
			<tr style="height: 18px;">
				<td style="width: 100%; height: 18px;text-align:center;font-size:22px;word-spacing:5px"><b>Voter Slip</b></td>
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
			<tr style="height: 18px;">
				<td style="height: 18px;font-size:18px;word-spacing:5px">नाम</td>
				<td style="height: 18px;font-size:18px;word-spacing:5px" colspan="3"><b>{{ $voterReport->name_l }}</b></td>
			</tr>
			<tr style="height: 18px;">
				<td style="height: 18px;font-size:18px;word-spacing:5px">लिंग</td>
				<td style="height: 18px;font-size:18px;word-spacing:5px"><b>{{$voterReport->genders_l}}</b></td>
				<td style="height: 18px;font-size:18px;word-spacing:5px">EPIC No. :</td>
				<td style="height: 18px;font-size:18px;word-spacing:5px"><b>{{ $voterReport->voter_card_no }}</b></td>
			</tr>
			<tr style="height: 18px;">
				<td style="height: 18px;font-size:18px;word-spacing:5px">{{ $voterReport->vrelation }}</td>
				<td style="height: 18px;font-size:18px;word-spacing:5px" colspan="3"><b>{{ $voterReport->father_name_l }}</b></td>
			</tr>
		</tbody>
	</table>
	<table width="100%">
		<tbody>
			<tr style="height: 18px;">
				<td style="width: 100%; height: 16px;font-size:18px;word-spacing:5px">मतदाता क्रमांक संख्या : <b>{{ $voterReport->print_sr_no }}</b></td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">Polling Station No. and Name : <b>{{ $voterReport->booth_no }} -  {{ $voterReport->pb_name }}</b> </td>
			</tr>
			<tr>
				<td style="font-size:18px;word-spacing:5px">Poll Date, Day and Time : <b>{{ $polldatetime->polling_day_time_l }}</b></td>
			</tr>
			<tr>
				<td>Note: 1 This Voter Slip can also be produced as an identification document</td>
			</tr>
			<tr>
				<td style="height: 36px;">Note: 2 Bringing this voter slip to the Polling Station is however not compulsory, it is issued only as convenience to electors</td>
			</tr>
			<tr style="height: 54px;">
				<td style="height: 54px;">Note: 3 If this voter slip does not have a photograph or it has wrong particulars or photograph, the voter can still be allowed to vote base on alternate identity documents permitted by the State Election Commission, Haryana</td>
			</tr>
		</tbody>
	</table>
	<table style="height: 28px; width: 100%;">
		<tbody>
			<tr style="height: 32px;">
				<td></td>
				<td style="width: 650px">&nbsp;</td> 
				<td style="width: 50px;text-align:center" align="center">
@php 
$image  =\Storage_path('/app'.$polldatetime->signature);
@endphp
					<img src="{{ $image }}" alt="" width="55px" height="60px" align="center">
				</td>
			</tr>
			<tr style="height: 18px;">
				<td style="width: 200px;font-size: 18px">&nbsp;Date : 01/01/2020</td>
				<td style="width: 300px">&nbsp;</td> 
				<td style="width: 220px;font-size: 22px">Returning Officer Municipal Committee Jhajjar</td>
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
