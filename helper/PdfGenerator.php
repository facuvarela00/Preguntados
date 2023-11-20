<?php
// PdfGenerator.php
require_once('third-party/dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator {
    public static function generatePdf($content, $filename,$formato) {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Establecer todos los márgenes en 5 mm
        $options->set('margin-top', '5mm');
        $options->set('margin-right', '5mm');
        $options->set('margin-bottom', '5mm');
        $options->set('margin-left', '5mm');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', $formato);
        $dompdf->render();

        // En lugar de guardar el archivo, envía el PDF al navegador
        $dompdf->stream($filename, array('Attachment' => false));
    }
}