<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<?php
$content=file_get_contents('http://localhost:8080/tmsc/system/voucher/voucherreports.php');
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require '../assets/vendor/autoload.php';




// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($content);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('reservation-report.pdf');
?>

<?php include '../footer.php'; ?>