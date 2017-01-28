@extends('layouts.app')

@section('content')
	<div class="col-md-4"></div>
	<div class="col-md-4" id="center">
	<div class="panel panel-default">
        <div class="panel-heading">
           <h2>QR-codes voor {{ $questName }}</h2>
        </div>
        <div class="panel-body">
			<a href="{{ url('/') }}">
				<button class="btn btn-primary" style = "margin-bottom: 25px;">Ga Terug</button>
			</a>
			<button class="btn btn-success" onclick="DownLoadPDF()" style = "margin-top: -25px;">DownLoad PDF</button>
		</div>
	</div>
	<div class="col-md-4"></div>
@endsection

@section('javascript')
<script>
	//create a new PDF file
 	var doc = new jsPDF();
 	var docX = 20
 	var docY = 50
 	var qrSizeX = 175;
 	var qrSizeY = 175;
 	
	//get markerIds from PHP
	var markerIds = <?php echo json_encode($markerIds); ?>;
	var markerNames = <?php echo json_encode($markerNames); ?>;

	$(document).ready(function() 
	{	
		// show the markers and the page and create PDF
		ShowQRCodesOnPageAndCreatePDF(markerIds);
	});

	function ShowQRCodesOnPageAndCreatePDF(markerIds) 
	{   
	    for (var i = 0; i < markerIds.length; i++)
	    {

	    	var qrName = document.createElement('h1');
	    	qrName.innerHTML = markerNames[i].toString();
	    	$('.panel-body')[0].append(qrName);

	    	//create div to hold the qr-code and add it to the center div
	    	var qrDiv = document.createElement("div");
	    	qrDiv.setAttribute('id', "qr-div"+i);
			$('.panel-body')[0].append(qrDiv);

	    	//create empty div to space the qr-code on the page and add it to the center div
	    	var space = document.createElement("div");
	    	space.setAttribute('class', 'spaceDiv');
	    	$('.panel-body')[0].append(space);

	       	var qrcode;
	        var options = 
	        {
	            width: 400,
	            height: 400,
	            colorDark : "#000000",
	            colorLight : "#FFFFFF",
	            correctLevel : QRCode.CorrectLevel.Q
	        };

	        //add the qr-code to the div with the options
	       	qrcode = new QRCode(qrDiv, options);
	       	qrcode.makeCode(markerIds[i].toString());

	       	//get the base64 string from the qr-image on the page
	       	var canvas = qrDiv.children[0];
	       	//add it to the PDF
			var imgData = canvas.toDataURL();
			doc.text(docX, docY, markerNames[i]);
			doc.addImage(imgData, 'PNG', docX, docY +10, qrSizeX, qrSizeY);

			//if we are not at the last marker add a new page to the PDF
			if (i !== markerIds.length -1)
			{
				doc.addPage();
			}
	    }
	}

	//download the PDF in the browser
	function DownLoadPDF()
	{
		doc.save('QR-codes.pdf')
	}
</script>
@endsection