<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div style="text-align:center;"><h2><b>Annexure-A</b></h2></div>
@foreach ($mainpagedetails as $mainpagedetail)
<table style="border: 1px solid black;">
<tbody>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 40px" colspan="5">&nbsp;{{ $mainpagedetail->year }} काशत ाम पंचायत/पंचायत समत /{{ $mainpagedetail->election_type }} मतदाता सूच सबिधत वधानसभा े का नाम : <b>{{ $mainpagedetail->district }}</b></td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black;height: 200px;margin-top: 5px" colspan="2">&nbsp;<br><b><h3>जिला का नाम : {{ $mainpagedetail->district }}</h3></b></td>
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
				<table style="border:1px solid black;
				font-size:11px;padding:0px;width: 220">
				<tbody>
					<tr>
						<td style="border: 1px solid black;width: 40px">{{ $voterReport->print_sr_no }}</td>
						<td style="width: 100px;text-align:center">{{ $voterReport->voter_card_no }}</td>
						<td style="border: 1px solid black;">&nbsp;{{ $voterReport->part_srno }}</td>
					</tr>
					<tr>
						<td style="width: 130px" colspan="2">नाम&nbsp; &nbsp; {{ $voterReport->name_l }}</td>
						<td style="" rowspan="4">
							<img src="">
						</td>
					</tr>
					<tr>
						<td style="width: 130px" colspan="2">{{ $voterReport->vrelation }}&nbsp; &nbsp; {{ $voterReport->father_name_l }}</td>
					</tr>
					<tr>
						<td style="" colspan="2">मकान नं०&nbsp; &nbsp; &nbsp;{{ $voterReport->house_no_l }}</td>
					</tr>
					<tr>
						<td style="" colspan="2">आयु&nbsp; &nbsp; &nbsp;{{ $voterReport->age }} &nbsp; &nbsp;लिंग&nbsp; &nbsp; &nbsp; {{ $voterReport->genders_l }}</td>
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
</body>
</html>