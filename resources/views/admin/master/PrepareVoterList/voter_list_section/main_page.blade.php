<div style="text-align:center;"><h2><b>Annexure-A</b></h2></div>
<div style="text-align:center;"><h2><b>मुख्य पृष्ठ</b></h2></div>
		@foreach ($mainpagedetails as $mainpagedetail)
		<table style="border: 1px solid black;" width="100%">
		<tbody>
		<tr>	
		<td style="height: 40px;word-spacing:4px">
			<table width="100%">
				<tr>
					<td>&nbsp;&nbsp;{{ $mainpagedetail->year }} में प्रकाशित {{ $mainpagedetail->election_type }} मतदाता सूचि सम्बन्धित विधानसभा क्षेत्र का नाम : {{ $mainpagedetail->district }}
					</td>
				</tr>
			</table>
		</td>
		</tr>
		
		<tr>
			<td>
				<table width="100%" style="border: 1px solid black;" >
					<tr style="border: 1px solid black;">			
						@php
						if ($main_page_type==1) {
							$colspan='30%';	 
		 				}else{
		  					$colspan='100%';	
		 				}	
						@endphp
						<td style="height: 150px;word-spacing:4px;padding-left: 20px" width="{{ $colspan }}"><h3><b>जिला का नाम : {{ $mainpagedetail->district }}</b></h3></td> 
        				@if ($main_page_type==1) 
						<td style="height: 150px;word-spacing:4px;padding-left: 20px" width="70%">
							<table width="100%">
							<thead>
								@php
									$part_no='';
								@endphp
								@foreach ($voterssrnodetails as $voterssrnodetail)
									@if ($part_no!=$voterssrnodetail->partno)
										@php
										$part_no=$voterssrnodetail->partno;
										$time=0; 
										@endphp
					     				<tr>
					     					<th colspan ="6">भाग संख्या  : {{ $part_no }}</th>
					     				</tr> 	
										<tr>
											<th style="text-align:center;width:95px">क्र०से</th>
											<th style="text-align:center;width:95px">क्र तक</th>
											<th style="text-align:center;width:95px">क्र०से</th>
											<th style="text-align:center;width:95px">क्र तक</th>
											<th style="text-align:center;width:95px">क्र०से</th>
											<th style="text-align:center;width:95px">क्र तक</th>
										</tr>
									@endif

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

							</thead>
							</table>
						</td>
						@endif
					</tr>
				</table>
			</td>
		</tr>
		{{-- <tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 150px;word-spacing: 4px" colspan="5">
		<table style="word-spacing: 4px">
		<tbody>
		<tr>
		 @if ($main_page_type==1) 
		<td style="border: 1px solid black;height: 120px;word-spacing: 4px" colspan="2"> 1. (क) ग्राम पंचायत का नाम व वार्ड संख्या : <b>{{ $mainpagedetail->village }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $mainpagedetail->ward }}</b>
		<br>
		<br>
		(ख) खंड का नाम  : <b>{{ $mainpagedetail->block }}</b>
		<br>
		<br>
		(ग) पंचायत समिति का नाम व वार्ड संख्या : <b>{{ $mainpagedetail->block }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  {{ $mainpagedetail->ps_ward }}</b> 
		<br> 
		<br> 
		(घ) जिला परिषद व वार्ड संख्या: <b>{{ $mainpagedetail->district }}&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;{{ $mainpagedetail->zp_ward }}</b>   
		</td> 
		 @else

		 @endif 
		</tr> 
		</tbody>
		</table> 
		</td>
		</tr>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 40px;word-spacing: 4px" colspan="5">&nbsp;&nbsp;2- पुनरीक्षण  का विवरण   </td>
		</tr>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 120px;word-spacing: 4px" colspan="2">
			
		&nbsp;&nbsp;&nbsp;पुनरीक्षण का वर्ष : <b>{{ $mainpagedetail->year }}</b>
		<br>
		<br>
		&nbsp;&nbsp;&nbsp;पुनरीक्षण की तिथि  : <b>{{ $mainpagedetail->publication_date }}</b>
		<br>
		<br>
		&nbsp;&nbsp;&nbsp;पुनरीक्षण का स्वरूप  : <b>{{ $mainpagedetail->list_type }}  {{ $mainpagedetail->year }}</b> 
		<br> 
		<br> 
		&nbsp;&nbsp;&nbsp;प्रकाशन की तिथि : <b>{{ $mainpagedetail->publication_date }}</b>  
		</td>
		<td style="border: 1px solid black;height: 120px;word-spacing: 4px;padding-left: 20px" colspan="3">
			
			नामावली  पहचान  : 
			<br>
			<br>
			नये परिसमिति निर्वाचन क्षेत्रो के विस्तारानुसार सभी अनुपूरकों सहित एकीकृत व  वर्ष <b>{{ $mainpagedetail->year }}</b> की पुनरीक्षित मूल निर्वाचक नामावली 
		</td>
		</tr>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 40px;word-spacing: 4px" colspan="5">&nbsp;&nbsp;मतदाताओं क संया </td>
		</tr>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">आरंभिक क्रम संख्या </td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">अंतिम  क्रम संख्या </td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">पुरुष</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">महिला</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">अन्य</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">कुल</td>
		</tr>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->from_sr_no }}</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->total }}</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->male }}</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->female }}</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->transgender }}</td>
		<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->total }}</td>
		</tr> --}}
		</tbody>
		</table>
		@endforeach
