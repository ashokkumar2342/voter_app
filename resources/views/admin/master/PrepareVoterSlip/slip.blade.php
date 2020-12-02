<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		table{
			 border-spacing: 5px;
			  
		}
	</style>
</head>
<body>
@foreach ($voterReports as $voterReport) 
<table width="100%">
<tbody>
<tr style="height: 18px;">
<td style="text-align:center;font-size:24px;word-spacing:5px" colspan="5">General Election to the नगर पालका झजर - 2016</td>
</tr>
<tr style="height: 18px;">
<td style="width: 572px; height: 18px;text-align:center;font-size:24px;word-spacing:5px" colspan="5">Voter Slip</td>
</tr>
<tr style="height: 13px;">
<td style="width: 75px; height: 13px;font-size:20px;word-spacing:5px;">वार्ड न० :</td>
<td style="width: 74px; height: 13px;font-size:20px;word-spacing:5px">1</td>
<td style="width: 93px; height: 13px;font-size:20px;word-spacing:5px">Part No. :</td>
<td style="width: 249px; height: 13px;font-size:20px;word-spacing:5px">50</td>
<td style="width: 91px; height: 67px;" rowspan="4">
@php	
$dirpath = '/app/vimage/2/355';
$name =37796;
$image  =\Storage_path($dirpath.'/'.$name.'.jpg');
@endphp
<img src="{{ $image }}" alt="" width="130px" height="130px">
</td>
</tr>
<tr style="height: 18px;">
<td style="width: 65px; height: 18px;font-size:20px;word-spacing:5px">नाम</td>
<td style="width: 416px; height: 18px;font-size:20px;word-spacing:5px" colspan="3">{{ $voterReport->name_l }}</td>
</tr>
<tr style="height: 18px;">
<td style="width: 65px; height: 18px;font-size:20px;word-spacing:5px">लिंग</td>
<td style="width: 74px; height: 18px;font-size:20px;word-spacing:5px">पुष</td>
<td style="width: 93px; height: 18px;font-size:20px;word-spacing:5px">EPIC No. :</td>
<td style="width: 249px; height: 18px;font-size:20px;word-spacing:5px">{{ $voterReport->voter_card_no }}</td>
</tr>
<tr style="height: 18px;">
<td style="width: 65px; height: 18px;font-size:20px;word-spacing:5px">पिता</td>
<td style="width: 74px; height: 18px;font-size:20px;word-spacing:5px">{{ $voterReport->father_name_l }}</td>
<td style="width: 93px; height: 18px;font-size:20px;word-spacing:5px">&nbsp;</td>
<td style="width: 249px; height: 18px;font-size:20px;word-spacing:5px">&nbsp;</td>
</tr>
<tr style="height: 18px;">
<td style="width: 572px; height: 16px;font-size:20px;word-spacing:5px" colspan="5">मतदाता क्रमांक संख्या : 2419</td>
</tr>
<tr>
<td colspan="5" style="font-size:18px;word-spacing:5px">Polling Station No. and Name : 1 कार्यालय उत्तर हरियाण बिजली वित्रण निगम </td>
</tr>
<tr>
<td colspan="5" style="font-size:18px;word-spacing:5px">Poll Date, Day and Time : 22/05/2016 (sunday) From 07:00 AM to 05:00 PM</td>
</tr>
<tr>
<td colspan="5">Note: 1 This Voter Slip can also be produced as an identification document</td>
</tr>
<tr>
<td style="width: 572px; height: 36px;" colspan="5">Note: 2 Bringing this voter slip to the Polling Station is however not compulsory, it is issued only as convenience to electors</td>
</tr>
<tr style="height: 54px;">
<td style="width: 790px; height: 54px;" colspan="5">Note: 3 If this voter slip does not have a photograph or it has wrong particulars or photograph, the voter can still be allowed to vote base on alternate identity documents permitted by the State Election Commission, Haryana</td>
</tr>
</tbody>
</table>
<table style="height: 28px; width: 700px;">
<tbody>
<tr style="height: 32px;">
<td></td>
<td style="width: 650px">&nbsp;</td> 
<td style="width: 50px;text-align:center" align="center">
	@php	
$dirpath = '/app/voterslip';
$name ='signature';
$image  =\Storage_path($dirpath.'/'.$name.'.jpeg');
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
@endforeach
</body>
</html>