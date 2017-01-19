@extends('layouts.app')

@section('content')
@endsection

@section('javascript')
<script>
	$(document).ready(function () 
	{	
		var markerIds = <?php echo json_encode($markerIds); ?>;
		makeQRCode(markerIds);

	 	// var doc = new jsPDF();
		// doc.text('Hello world!', 10, 10);
		// doc.save('QR-codes.pdf');
		// doc.output('dataurlnewwindow');
		// history.go(-1);

	});

	function makeQRCode (markerIds) 
	{   
	    for (var i = 0; i < markerIds.length; i++)
	    {
	    	var qrDiv = document.createElement("div");

	    	qrDiv.setAttribute('id', "qr-div"+i);
			$('body')[0].append(qrDiv);
	        
	        var options = 
	        {
	            width: 65,
	            height: 65,
	            colorDark : "#000000",
	            colorLight : "#FFFFFF",
	            correctLevel : QRCode.CorrectLevel.Q
	        };

	       var qrcode
	       qrcode = new QRCode(qrDiv, options);
	       qrcode.makeCode(markerIds[i].toString());

	       	var src = getBase64Image(qrDiv.children[1]);
	   		//var src = atob(qrDiv.children[1].src);

	   		console.log(src);


	    }
	}

	function getBase64Image(img) {
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}
</script>
@endsection