<?php
// PdfGenerator.php
require_once('third-party/dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator {
    public static function generatePdf($content, $filename) {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // En lugar de guardar el archivo, envía el PDF al navegador
        $dompdf->stream($filename, array('Attachment' => false));
    }
}