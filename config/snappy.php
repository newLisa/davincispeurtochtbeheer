<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' =>'"C:\wkhtmltopdf/bin/wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => '"vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
