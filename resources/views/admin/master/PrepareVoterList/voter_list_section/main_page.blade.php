<table id="headertable" style="border: 0px text-align: center;" width="100%">
	<tr>
		<td style="align-content: center; text-align: center;font-size: 14px; font-weight: bold;">
			Annexure-A
		</td>
	</tr>
	<tr>
		<td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">
			मुख्य पृष्ठ
		</td>
	</tr>
</table>
		@foreach ($mainpagedetails as $mainpagedetail)
		<table id="detailtable" style="border: 1px solid black;" width="100%">
		<tbody>
		<tr>	
		<td style="height: 40px;word-spacing:4px">
			<table width="100%">
				<tr>
					<td style="border: 1px solid black;" >{{ $mainpagedetail->year }} में प्रकाशित {{ $mainpagedetail->election_type }} मतदाता सूचि सम्बन्धित विधानसभा क्षेत्र का नाम : {{ $mainpagedetail->district }}
					</td>
				</tr>
			</table>
		</td>
		</tr>
		
		<tr>
			<td>
				<table width="100%" >
					<tr>			
						@php
						if ($main_page_type==1) {
							$colspan='40%';	 
		 				}else{
		  					$colspan='100%';	
		 				}	
						@endphp
						<td style="height: 150px;word-spacing:4px;padding-left: 20px;border: 1px solid black; font-size: 14px; font-weight: bold;" width="{{ $colspan }}">जिला का नाम : {{ $mainpagedetail->district }}</td> 
        				@if ($main_page_type==1) 
						<td style="height: 150px;word-spacing:4px;padding-left: 2px;border: 1px solid black;" width="60%">
							<table width="100%">
							<thead>
								@php
									$part_no='';
									$time=0;
									$counter=0;
								@endphp
								@foreach ($voterssrnodetails as $voterssrnodetail)
									@if ($part_no!=$voterssrnodetail->partno)
										@php
										$part_no=$voterssrnodetail->partno;
										$time=0;
										$counter++;
										$counter++; 
										@endphp
					     				<tr>
					     					<th colspan ="6">भाग संख्या  : {{ $part_no }}</th>
					     				</tr> 	
										<tr>
											<th width = "17%" style="text-align:center;">क्र०से</th>
											<th width = "17%" style="text-align:center;">क्र तक</th>
											<th width = "17%" style="text-align:center;">क्र०से</th>
											<th width = "17%" style="text-align:center;">क्र तक</th>
											<th width = "16%" style="text-align:center;">क्र०से</th>
											<th width = "16%" style="text-align:center;">क्र तक</th>
										</tr>
									@endif

									@if ($time==0)
									@php
									$counter++;
									@endphp
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

								{{-- @if ($time=1)
									<td></td> <td></td> <td></td> <td></td> </tr>
								@endif --}}
								{{-- @if ($time=2)
									<td></td> <td></td> </tr>
								@endif --}}

							</thead>
							</table>
						</td>
						@endif
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width = "100%">
				<table width = "100%">
					<tr>
		 			@if ($main_page_type==1) 
						<td style="border: 1px solid black;height: 120px;word-spacing: 4px" width="100%"> 1. (क) ग्राम पंचायत का नाम व वार्ड संख्या : <b>{{ $mainpagedetail->village }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $mainpagedetail->ward }}</b>
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
		 				<td style="border: 1px solid black;height: 120px;word-spacing: 4px" width="100%"> {{ $mainpagedetail->election_type }} का नाम व वार्ड संख्या : <b>{{ $mainpagedetail->village }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $mainpagedetail->ward }}</b>
						<br>
						<br>
						</td>
		 			@endif 
					</tr>	
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%">
				<table width = "100%">
					<tr>
						<td style="border: 1px solid black;" width="100%">2- पुनरीक्षण  का विवरण
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width = "100%">
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black;height: 120px;word-spacing: 4px" width="50%">	
							पुनरीक्षण का वर्ष : <b>{{ $mainpagedetail->year }}</b>
							<br><br>
							पुनरीक्षण की तिथि  : <b>{{ $mainpagedetail->publication_date }}</b>
							<br><br>
							पुनरीक्षण का स्वरूप  : <b>{{ $mainpagedetail->list_type }}  {{ $mainpagedetail->year }}</b> 
							<br><br>
							प्रकाशन की तिथि : <b>{{ $mainpagedetail->publication_date }}</b>  
						</td>
						<td style="border: 1px solid black;height: 120px;word-spacing: 4px;padding-left: 5px;text-align: justify-all;" width="50%">
							नामावली  पहचान  : 
							<br>
							नये परिसमिति निर्वाचन क्षेत्रो के विस्तारानुसार सभी अनुपूरकों सहित एकीकृत व  वर्ष <b>{{ $mainpagedetail->year }}</b> की पुनरीक्षित मूल निर्वाचक नामावली 
						</td>
					</tr>			
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width = "100%">
					<tr>
						<td style="border: 1px solid black;" width="100%">मतदाताओं की संख्या</td>
					</tr>
				</table> 
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="17%">आरंभिक क्रम संख्या </td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="17%">अंतिम  क्रम संख्या </td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="17%">पुरुष</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="17%">महिला</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="17%">अन्य</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px" width="15%">कुल</td>
					</tr>
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->from_sr_no }}</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->total }}</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->male }}</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->female }}</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->transgender }}</td>
						<td style="border: 1px solid black;height: 40px;text-align:center;word-spacing: 4px">{{ $mainpagedetail->total }}</td>
					</tr>			
				</table>
			</td>
		</tr>
		</tbody>
		</table>
		@endforeach

		@php
			$counter = 21-$counter;
			if ($counter>14){
				$counter=14;
			}
			$margintop = $counter*20;
			// $margintop = 0;
		@endphp

	{{-- @push('scripts')
	<script type="text/javascript">
		function findtablesheight(){
			var x = 1000-(document.getElementById('headertable').offsetHeight+document.getElementById('detailtable').offsetHeight);

			document.write("<table style='margin-top:"+ 100 + "px;'>");
			document.write("<tr><td>&nbsp;"+x+"</td></tr></table>");
		}
	</script>
	@endpush --}}

	@push('scripts')
	<script type="text/javascript">findtablesheight();</script>
	@endpush
	
	<table width="100%" style='margin-top:{{$margintop}}px;'>
		<tr>
			<td width="48%" style="text-align: left;font-size: 11px;word-spacing: 4px"><b>*</b> {{ $mainpagedetails[0]->year }} को अंतिम प्रकाशित विधानसभा मतदाता सूचि का क्रo/भाग  नo आयु {{ $mainpagedetails[0]->publication_date }} के अनुसार संशोधित</td> 
			<td width="52%" align="right" style="text-align: right;font-size: 12px;word-spacing: 4px"> कुल {{$totalpage}} पृष्ठों का पृष्ठ 1</td>
				        
		</tr>
	</table>
	<pagebreak>	

	{{-- </div> --}}
