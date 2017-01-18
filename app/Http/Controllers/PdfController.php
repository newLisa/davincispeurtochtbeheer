<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Response;

class PdfController extends Controller
{
    public function index()
    {
    	$snappy = PDF::snappy();
		//To file
		$html = '<h1>Bill</h1><p>You owe me money, dude.</p>';
		$snappy->generateFromHtml($html, 'C:/Users/nicog/AppData/Local/Temp/bill-123.pdf');
		//$snappy->generate('http://www.github.com', '/tmp/github.pdf');
		//Or output:
		var_dump($snappy->getOutputFromHtml($html));
		return new Response(
		    $snappy->getOutputFromHtml($html),
		    200,
		    array(
		        'Content-Type'          => 'application/pdf',
		        'Content-Disposition'   => 'attachment; filename="file.pdf"'
		    )
		);
/*
		$data = 'piemel';
		PDF::loadHTML("http://github.com")->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0)->save('myfile.pdf');*/
    }
}
