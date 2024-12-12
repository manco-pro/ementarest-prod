
<?php
require_once '../../cOmmOns/config.inc.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$data = 'https://maps.app.goo.gl/Ez7HGD3YFtbHY8Do9'; // inserting the URL of iMasters

$options = new QROptions([
    'version' => 7, // version of the QRCode
    'eccLevel' => QRCode::ECC_L, // Error Correction Feature Level L
    'outputType' => QRCode::OUTPUT_IMAGE_PNG, // setting the output as PNG
    'imageBase64' => FALSE, // avoiding generating the image in base64
    'drawCircularModules' => false,
    'circleRadius' => 0.45
]);

file_put_contents('image.png', (new QRCode($options))->render($data)); // saving the image as png
