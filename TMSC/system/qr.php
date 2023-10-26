<?php
//Qr image store path
$qr_path='assets/qr/';

include "assets/phpqrcode/qrlib.php";

if(!file_exists($qr_path))
    mkdir($qr_path);

//scanning level
$errorCorrectionLevel= 'L';
$matrixPointSize= 4;

//$data=7896789;
$data=123;
$filename= $qr_path . 'test' . md5($data . '|' . $errorCorrectionLevel . '|' .$matrixPointSize).'.png';

//create qrcode class object and call method png
QRcode::png($data,$filename,$errorCorrectionLevel,$matrixPointSize,2);

echo '<img src="' . $qr_path . basename($filename) . '" />';

?>