<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
@foreach ($WardVillages as $WardVillage) 
	@php
		$voterListMaster=App\Model\VoterListMaster::where('status',1)->first(); 
        $mainpagedetails= Illuminate\Support\Facades\DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$WardVillage->id;")); 
        $voterssrnodetails = Illuminate\Support\Facades\DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $WardVillage->id;"));
        $voterReports =Illuminate\Support\Facades\DB::select(DB::raw("call up_process_voterlist ('$WardVillage->id')"));
	@endphp
<div style="text-align:center;"><h2><b>Annexure-A</b></h2></div>
@foreach ($mainpagedetails as $mainpagedetail)
<table style="border: 1px solid black;">
<tbody>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px" colspan="5">&nbsp;{{ $mainpagedetail->year }}काशत ाम पंचायत/पंचायत समत /{{ $mainpagedetail->election_type }} मतदाता सूच सबिधत वधानसभा े का नाम :</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 200px;margin-top: 5px" colspan="2">&nbsp;<br><b><h3>िजले का नाम : {{ $mainpagedetail->district }}</h3></b></td>
<td style="border: 1px solid black;height: 200px" colspan="3">
	<div>
		भाग संया  : 16
	</div>
	 <table style="width: 370px;">
		<thead>
			<tr>
				<th style="text-align:center">कसे</th>
				<th style="text-align:center">तक</th>
				<th style="text-align:center">कसे</th>
				<th style="text-align:center">तक</th>
				<th style="text-align:center">कसे</th>
				<th style="text-align:center">तक</th>
			</tr>
		</thead>
		<tbody>
			@php
          $time =0;
        @endphp
	       @foreach ($voterssrnodetails as $voterssrnodetail)
	       @if ($time==0)
	       <tr>
	       @endif 
	         <td style="text-align:center"> {!! $voterssrnodetail->fromsrno !!}</td>
	         <td style="text-align:center"> {!! $voterssrnodetail->tosrno !!} </td>
	       @if ($time ==2)
	         </tr>
	       @endif
	         @php
	           $time ++;
	         @endphp
	         @if ($time==3)
	          @php
	            $time=0;
	          @endphp
	         @endif
	        @endforeach 
		</tbody>
	</table>
</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 150px" colspan="5"> 
	1 . (क) ाम पंचायत का नाम व वाड संया : <b>{{ $mainpagedetail->village }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $mainpagedetail->ward_id }}</b>
	<br>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;खड का नाम : <b>{{ $mainpagedetail->block }}</b>
	<br>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ख) पंचायत समत का नाम व वाड संया : <b>{{ $mainpagedetail->block }}</b>
	<br>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ग) िजला परषद व वाड संया  : <b>{{ $mainpagedetail->district }}</b>
</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px" colspan="5">2- पुनरण का ववरण </td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 120px" colspan="2">
	
&nbsp;&nbsp;&nbsp;पुनरण का वष : <b>{{ $mainpagedetail->list_type }}</b>
<br>
<br>
&nbsp;&nbsp;&nbsp;पुनरण क तथ : <b>{{ $mainpagedetail->publication_date }}</b>
<br>
<br>
&nbsp;&nbsp;&nbsp;पुनरण का वप : <b>{{ $mainpagedetail->list_type }}  {{ $mainpagedetail->year }}</b> 
<br> 
<br> 
&nbsp;&nbsp;काशन क तथ : <b>{{ $mainpagedetail->publication_date }}</b>  
</td>
<td style="border: 1px solid black;height: 120px" colspan="3">
	
	नामावल पहचान : 
	<br>
	नये परसमत नवाचन े के वतारानुसार सभी अनुपूरक सहत एककृत व वष  <b>{{ $mainpagedetail->year }}</b> क पुनरत मूल नवाचक नामावल 
</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px" colspan="5">मतदाताओं क संया </td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px">आरंभक म संया</td>
<td style="border: 1px solid black;height: 40px">अंतम म संया</td>
<td style="border: 1px solid black;height: 40px">पुष</td>
<td style="border: 1px solid black;height: 40px">महला</td>
<td style="border: 1px solid black;height: 40px">कुल</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px">&nbsp;</td>
<td style="border: 1px solid black;height: 40px">&nbsp;</td>
<td style="border: 1px solid black;height: 40px">{{ $mainpagedetail->male }}</td>
<td style="border: 1px solid black;height: 40px">{{ $mainpagedetail->female }}</td>
<td style="border: 1px solid black;height: 40px">{{ $mainpagedetail->total }}</td>
</tr>
</tbody>
</table>
<div style="page-break-before: always;"></div>
@php
$time=0;
@endphp
@foreach ($voterReports as $voterReport) 
@if ($time==0)
<table style="">
	<tbody>
		<tr>
			@endif  
			<td> 
				<table style="border: 2px solid black;
				font-size:11px;padding:2px;">
				<tbody>
					<tr>
						<td style="border: 1px solid black;">1234</td>
						<td style="">xzfd123456</td>
						<td style="border: 1px solid black;">&nbsp;1234/1234</td>
					</tr>
					<tr>
						<td style="width: 130px" colspan="2">Name&nbsp; &nbsp; {{ $voterReport->name_l }}</td>
						<td style="" rowspan="4">
							<img src="">
						</td>
					</tr>
					<tr>
						<td style="width: 130px" colspan="2">Father&nbsp; &nbsp; {{ $voterReport->father_name_l }}</td>
					</tr>
					<tr>
						<td style="" colspan="2">मकान नं०&nbsp; &nbsp; &nbsp; 12</td>
					</tr>
					<tr>
						<td style="" colspan="2">आयु&nbsp; &nbsp; &nbsp; 20&nbsp; &nbsp; &nbsp; ͧलिंग&nbsp; &nbsp; &nbsp; पुरुष</td>
					</tr>
				</tbody>
			</table> 
		</td> 
		@if($time==2)
			</tr>
		</tbody>

	</table>

@endif
@php
$time ++;
@endphp
@if ($time==3)
@php
$time=0;
@endphp
@endif 
@endforeach
@endforeach
@endforeach	
</body>
</html>