<!DOCTYPE html>
<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
<style> 
	body{
	  font-family: 'Mangal';
	  font-style: 'bold';
	  font-weight: 'bold';
	  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
	}
	@font-face {
	  font-family: 'Mangal';
	  font-style: 'bold';
	  font-weight: 'bold';
	  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
	}
	 
.header {
    top: -30px;
    width: 100%;
    text-align: center;
    position: fixed;
}
.footer {
    bottom: 0px;
    width: 100%;
    text-align: center;
    position: fixed;
}
 
#pageCounter span {
  counter-increment: pageTotal; 
}
#pageNumbers {
  counter-reset: currentPage;
}
#pageNumbers div:before { 
  counter-increment: currentPage; 
  content: "Page " counter(currentPage) " of "; 
}
#pageNumbers div:after { 
  content: counter(pageTotal); 
} 
</style> 
{{-- @include('admin.include.boostrap') --}}
</head> 
<body >
<div style="text-align:center;font-family:sans-serif;"><h2><b>Annexure-A</b></h2></div>
<div style="text-align:center;margin-top: -50px"><h2><b>मुय पृठ</b></h2></div>
@foreach ($mainpagedetails as $mainpagedetail) 
<table style="width: 720px;border: 1px solid black;">
<tbody>
<tr style="border: 1px solid black; height: 23px;">
<td style="border: 1px solid black; width: 572px; height: 23px;" colspan="5">{{ $mainpagedetail->year }}  म काशत ाम पंचायत/पंचायत समत /{{ $mainpagedetail->election_type }} मतदाता सूच सबिधत वधानसभा े का नाम :</td>
</tr>
<tr style="border: 1px solid black; height: 220px;">
<td style="border: 1px solid black; width: 271px; height: 220px;" colspan="2">
	िजले का नाम : {{ $mainpagedetail->district }} 
</td>
<td style="border: 1px solid black; width: 301px; height: 220px;" colspan="3">
<div class="row"> 
	<div class="col-lg-12">
		भाग संया  : 16
	</div>
	<table style="width: 370px;border: 1px solid black;">
		<thead>
			<tr>
				<th>कसे</th>
				<th>तक</th>
				<th>कसे</th>
				<th>तक</th>
				<th>कसे</th>
				<th>तक</th>
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
	       @if ($time ==3)
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
</div>
</td>
</tr>
<tr style="border: 1px solid black;">
<td style="border: 1px solid black; width: 114px;" colspan="5">
	1 . (क) ाम पंचायत का नाम व वाड संया : <b>{{ $mainpagedetail->village }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $mainpagedetail->ward_id }}</b>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;खड का नाम : <b>{{ $mainpagedetail->block }}</b>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;( ख) पंचायत समत का नाम व वाड संया : <b>{{ $mainpagedetail->block }}</b>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp;( ग) िजला परषद व वाड संया  : <b>{{ $mainpagedetail->district }}</b>
</td>
</tr>
<tr style="border: 1px solid black; height: 23px;">
<td style="border: 1px solid black; width: 114px; height: 23px;" colspan="5">
	2- पुनरण का ववरण 
</td>
</tr>
<tr style="border: 1px solid black; height: 105px;">
<td style="border: 1px solid black; width: 114px; height: 105px;" colspan="2">
&nbsp;पुनरण का वष : <b>{{ $mainpagedetail->list_type }}</b>
<br>
&nbsp;पुनरण क तथ : <b>{{ $mainpagedetail->publication_date }}</b>
<br>
&nbsp;पुनरण का वप : <b>{{ $mainpagedetail->list_type }}  {{ $mainpagedetail->year }}</b> 
<br> 
&nbsp;काशन क तथ : <b>{{ $mainpagedetail->publication_date }}</b>  
</td>
<td style="border: 1px solid black; width: 71px; height: 105px;" colspan="3">
	नामावल पहचान : 
	<br>
	नये परसमत नवाचन े के वतारानुसार सभी अनुपूरक सहत एककृत व वष  <b>{{ $mainpagedetail->year }}</b> क पुनरत मूल नवाचक नामावल 
</td>
</tr>
<tr style="border: 1px solid black; height: 24px;">
<td style="border: 1px solid black; width: 114px; height: 24px;" colspan="5">
मतदाताओं क संया 
</td>
</tr>
<tr style="border: 1px solid black; height: 24px;">
<td style="border: 1px solid black; width: 114px; height: 24px;text-align:center">आरंभक म संया </td>
<td style="border: 1px solid black; width: 157px; height: 24px;text-align:center">अंतम म संया </td>
<td style="border: 1px solid black; width: 71px; height: 24px;text-align:center">पुष</td>
<td style="border: 1px solid black; width: 115px; height: 24px;text-align:center">महला </td>
<td style="border: 1px solid black; width: 115px; height: 24px;text-align:center">कुल </td> 
<tr style="border: 1px solid black; height: 24px;">
<td style="border: 1px solid black; width: 114px; height: 24px;text-align:center">1</td>
<td style="border: 1px solid black; width: 157px; height: 24px;text-align:center">20</td>
<td style="border: 1px solid black; width: 71px; height: 24px;text-align:center"><b>{{ $mainpagedetail->male }}</b></td>
<td style="border: 1px solid black; width: 115px; height: 24px;text-align:center"><b>{{ $mainpagedetail->female }}</b></td>
<td style="border: 1px solid black; width: 115px; height: 24px;text-align:center"><b>{{ $mainpagedetail->total }}</b></td>
</tr>
</tbody>
</table>   
<div style="page-break-before: always;"> </div>
<div class="header">
	पंचायत : अहर &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $mainpagedetail->voter_list_type }} नवाचान नामावल , {{ $mainpagedetail->year }} &nbsp;&nbsp;&nbsp;&nbsp;वाड संया :1
    <hr style="width: 750px;margin-left: -20px">
 </div>
 <div class="footer" style="font-family:sans-serif;"> 
    <div id="pageCounter"> 
      <span></span>
    </div>
    <div id="pageNumbers">
      <div class="page-number"></div> 
    </div>
</div>
 @php
  $time =0;
@endphp
@foreach ($voterReports as $voterReport) 
@if ($time==0)
<table style="width: 750px;margin-left: -20px">
	<tbody>
		<tr>
@endif 

			<td> 
				<table style="border: 1px solid black;
					font-size: 9px;padding:1px;width: 242px">
					<tbody>
						<tr>
							<td style="border: 1px solid black;">1234</td>
							<td style="">xzfd123456</td>
							<td style="border: 1px solid black;">&nbsp;1234/1234</td>
						</tr>
						<tr>
							<td style="width: 130px" colspan="2">Name&nbsp; &nbsp; {{ $voterReport->name_e }}</td>
							<td style="" rowspan="4">
								<img src="">
							</td>
						</tr>
						<tr>
							<td style="width: 130px" colspan="2">Father&nbsp; &nbsp; {{ $voterReport->father_name_e }}</td>
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
@if ($time==3)
</table>
	</tbody>
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
@endforeach 
</body> 
</html>