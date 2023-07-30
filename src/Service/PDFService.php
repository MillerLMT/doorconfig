<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderAccessories;
use Twig\Environment;

/**
 * Сервис для генерации и сохранения pdf-файла с информацией о заказе
 */
class PDFService
{
    public $twig;

    public function __construct(Environment $twig)
    {
        $this->twig=$twig;
    }

    public function generatePDF($data)
    {
        $tcpdfPath = $_SERVER['DOCUMENT_ROOT'] . '/../external/tcpdf/tcpdf.php';
        require_once $tcpdfPath;

        $pdf = new \TCPDF();

        $pdf->setFontSubsetting(false);
        $pdf->SetFont('dejavusans', '', 8);

        $pdf->AddPage();

        $template = 'pdf/order.html.twig';
        $html = $this->twig->render($template, $data);

        $pdf->writeHTML($html, true, 0, true, 0);

        $pdf->lastPage();

        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/../files/pdf/'. $data['order']->getId() .'.pdf';
        $pdf->Output($filePath, 'F');
    }
}