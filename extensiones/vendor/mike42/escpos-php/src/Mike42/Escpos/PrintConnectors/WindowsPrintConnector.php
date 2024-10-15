<?php
// Asegúrate de que la ruta sea correcta
require_once('vendor/autoload.php'); 
use TCPDF;

// Función para generar un PDF
function generatePDF($content, $pdfPath) {
    // Crear nuevo PDF
    $pdf = new TCPDF();
    
    // Configuración del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Autor');
    $pdf->SetTitle('Título del PDF');
    $pdf->SetSubject('Asunto del PDF');
    $pdf->SetKeywords('TCPDF, PDF, ejemplo');

    // Añadir una página
    $pdf->AddPage();
    
    // Establecer fuente
    $pdf->SetFont('helvetica', '', 12);
    
    // Escribir contenido
    $pdf->Write(0, $content);
    
    // Guardar el PDF en la ruta especificada
    $pdf->Output($pdfPath, 'F'); 
}

// Contenido que deseas imprimir en el PDF
$content = "Este es un ejemplo de contenido para el PDF.";

// Ruta donde se guardará el PDF
$pdfFilePath = 'reporte.pdf';

// Generar el PDF
generatePDF($content, $pdfFilePath);

// Imprimir el PDF
$printerName = '\\\\YourComputerName\\Microsoft Print to PDF'; // Cambia esto según tu configuración

// Comando para imprimir
$command = sprintf("print /D:\"%s\" \"%s\"", $printerName, $pdfFilePath);
exec($command, $output, $retval);

// Verificar si hubo errores
if ($retval === 0) {
    echo "PDF enviado a la impresora correctamente.";
} else {
    echo "Error al enviar el PDF a la impresora: " . implode("\n", $output);
}
?>
