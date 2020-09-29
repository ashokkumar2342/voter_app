<!DOCTYPE html>
<html>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">
	<style> 

		body{
		  font-family: 'mangal' !important;
		  font-style: 'bold';
		  font-weight: 'bold';
		  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
		}
		@font-face {
		  font-family: 'mangal' !important;
		  font-style: 'bold';
		  font-weight: 'bold';
		  src: url('https://github.com/nsisodiya/rajiv-bharat/raw/master/fonts/MANGAL.ttf') format('truetype');
		}
	</style>
</head>
<body>
	@foreach ($voterReports as $voterReport) 
	<p>{{ $voterReport->name_l }}</p>
	@endforeach
</body>
</html>
