<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Response;
use QrCode;

class PdfController extends Controller
{
    public function index()
    {
    	$snappy = PDF::snappy();
		//To file
		//
		QrCode::size(600);
		QrCode::generate('sfd');
		
		/*$html = QrCode::generate('sfd');
		$snappy->generateFromHtml($html,public_path('/test/test'.rand(1,9999999999).'.pdf'));
		//$snappy->generate('http://www.github.com', '/tmp/github.pdf');
		//Or output:
		$resp =  new Response(
		    $snappy->getOutputFromHtml($html),
		    		    		    200,
		    		    		    array(
		    		    		        'Content-Type'          => 'application/pdf',
		    		    		        'Content-Disposition'   => 'attachment; filename="file.pdf"'
		    		    		    )
		);*/



		//return $snappy->download('invoice.pdf');
/*
		$data = 'piemel';
		PDF::loadHTML("http://github.com")->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0)->save('myfile.pdf');*/
    }

    public function DownloadPdf()
    {
    	  return view('test/qrtest');
    }
}
