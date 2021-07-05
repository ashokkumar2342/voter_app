<!DOCTYPE html>
<html>
<head>
	<title>Card Print</title>
</head>
<style type="text/css">
	@page{margin:10;} 
</style>
<body>
	<div style="position: fixed; left: 0px; top: 0px; bottom: 0px; right: 0px; bottom: 0px; text-align: center;">
<img src="{{ $backgroundImg }}" style="width: 100%;"> 
</div>
	<table>
		<tr>
			<th></th> 
		</tr>
	</table> 
	<table style="margin-top: 80px" width="100%">
		<tr>
			<th width="45%"><barcode code="{{ $value }}" height="0.7" type="C128B" class="barcode" /></th>
			<th width="55%" style="font-size: 17px;padding-left: 8px">{{ $value }}</th>
		</tr>
	</table>
	@php  
	$dirpath = '/app/vimage/'.'2'.'/'.'355';
	$name =37809;
	$image  =\Storage_path($dirpath.'/'.$name.'.jpg');
	@endphp
	<table style="margin-top:2px;padding-left: 5px">
		<tr>
			<td width="20%"></td>
			<td width="60%"><img src="{{ $image }}" alt="" width="100px" height="120px"> </td>
			<td width="20%"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 300px;font-size: 15px;">नाम : सन्तोष </td> 
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 300px;font-size: 15px;font-weight: bold;padding-top:6px">Name : SANTOSH</td> 
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 300px;font-size: 15px;padding-top:6px">पिता का नाम : महेन्द्र सिंह </td> 
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 300px;font-size: 15px;font-weight: bold;padding-top:6px">Father's Name : MAHENDER SINGH</td>
		</tr>
	</table>
	<pagebreak>
	<table style="font-size: 7px" width="100%">
		<tr>
			<td style="width:55px">लिंग/<b>Gender</b> :</td>
			<td style="width:45px">महिला &nbsp;/&nbsp; <b>Female</b></td>
		</tr> 
	</table>
	<table style="font-size: 7px;margin-top: -3px" width="60%">
		<tr> 
			<td>जन्म तिथि / आयु :<br><b>Data of birth / Age</b> :</td>
			<td><b>65</b></td> 
		</tr> 
	</table>
	<table style="font-size: 7px;margin-top: -3px" width="100%">
		<tr> 
			<td>पता: म.नं.161, गांव-नूना माजरा, तह-बहादुरगढ़, जिला-झज्जर<br>
			<b>Address : HNo.161, VILL-NUNA MAJRA,TEH-BAHADURGRAH, DIST-JHAJJSR</b></td>
			 
		</tr> 
	</table>
	<table width="100%">
		<tr> 
			<td></td> 
		</tr> 
	</table>
	<table style="font-size: 7px" width="100%">
		<tr> 
			<td>तिथि /<b> Date : 29-09-2020</b></td> 
			<td>निर्वाचक रजिस्ट्रीकरण अधिकारी <br><b>Electoral Ragistration Officer</b></td> 
		</tr> 
	</table>
	<table style="font-size: 7px" width="100%">
		<tr> 
			<td>विधान सभा निर्वाचन क्षेत्र संख्या व नाम : 64-बहादुरगढ़ <br> <b>Assembly Constituency No. and Name : 64-BAHADURGRAH</b></td> 
			 
		</tr> 
	</table>
	<table style="font-size: 7px" width="100%">
		<tr> 
			<td>भाग संख्या व नाम : 208 नूना माजरा <br><b>Part No. And Name :208-NUNA MAJRA</b></td> 
			 
		</tr> 
	</table>
	<div style="position: absolute;overflow: visible;left: 50;margin-top:170px;
    margin-bottom: auto;font-size: 7px"><b>Old EPIC No.- HR/04/37/0471626</b></div>
</body>
</html>