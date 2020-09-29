<!DOCTYPE html>
<html>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
	<style> 

		body{
		  font-family: 'MANGAL' !important;
		  font-style: 'bold';
		  font-weight: 'bold';
		  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
		}
		@font-face {
		  font-family: 'MANGAL' !important;
		  font-style: 'bold';
		  font-weight: 'bold';
		  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
		}
	</style>
</head>
<body>
	<div style="text-align:center;"><h1>Annexure-A </h1> 
	</div> 
	<table style="border: 1px solid black;
	padding: 8px;">
	<tbody>
		<tr >
			<td colspan="5" style="border: 1px solid black;
			padding: 8px;">2015 म काशत नगर पालका मतदाता सूच सबिधत वधानसभा े का नाम :- बहादरुगढ़ मुय पृठ </td>
		</tr>
		<tr>
			<td colspan="5" style="border: 1px solid black;
			padding: 8px;">िजले का नाम : झजर</td>
		</tr> 
		<tr>
			<td colspan="5" style="height: 200px" style="border: 1px solid black;
			padding: 8px;">dddddddd</td>
		</tr>
		<tr>
			<td colspan="5" style="border: 1px solid black;
			padding: 8px;">2- पुनरण का ववरण </td>
		</tr>
		<tr>
			<td colspan="2" style="height: 200px;border: 1px solid black;
			padding: 8px;">नामावल पहचान : 
			काशन क तथ : 30/11/2015
		पुनरण क तथ : 01/01/2015 पुनरण का वष : 2015 </td>
		<td colspan="3" style="height: 200px;border: 1px solid black;
		padding: 8px;">नामावल पहचान : 
		काशन क तथ : 30/11/2015
	पुनरण क तथ : 01/01/2015 पुनरण का वष : 2015 </td>
</tr>
<tr>
	<td colspan="5" style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
</tr>
<tr>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
</tr>
<tr>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
	<td style="border: 1px solid black;
	padding: 8px;">dddddddd</td>
</tr> 
</tbody>
</table>
<div style="page-break-before: always;"> </div>
<div>
	<header>header on each page</header> 
</div>

  
 @php
  $time =0;
@endphp
@foreach ($voterReports as $voterReport) 
@if ($time==0)
<table>
	<tbody>
		<tr>
@endif 

			<td> 
				<table style="border: 1px solid black;
					font-size: 12px;padding:1px;">
					<tbody>
						<tr>
							<td style="border: 1px solid black;">1234</td>
							<td style="">xzfd123456</td>
							<td style="border: 1px solid black;">&nbsp;1234/1234</td>
						</tr>
						<tr>
							<td style="" colspan="2">नाम&nbsp; &nbsp; &nbsp; {{ $voterReport->name_l }}</td>
							<td style="" rowspan="4">
								{{-- <img src="http://eageskool.com/front_asset/images/hdg-01.jpg" alt=""> --}}
							</td>
						</tr>
						<tr>
							<td style="" colspan="2">पिता&nbsp; &nbsp; &nbsp; {{ $voterReport->father_name_l }}</td>
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
</body>
</html>
