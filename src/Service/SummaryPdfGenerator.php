<?php


namespace App\Service;

use TCPDF;

class SummaryPdfGenerator
{
    public function generate($summary, $outputPath)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();


        $fontSize = 14;

        $pdf->SetFont('helvetica', '', $fontSize);

        $pdf->setCellPaddings(0, 0, 0, 0);
        $pdf->setCellHeightRatio(1.0);

        $pdf->SetAutoPageBreak(false, 0);

        $sections = explode("\n\n", $summary);
        foreach ($sections as $section) {
            $lines = explode("\n", $section);
            foreach ($lines as $line) {
                if (preg_match('/^(\s*[\*\-\•]\s+)/', $line)) {
                    // Format bullet points
                    $pdf->SetFont('helvetica', 'B', $fontSize);
                    $pdf->SetTextColor(0, 102, 204); // Blue color
                    $pdf->MultiCell(0, 5, trim($line), 0, 'L', 0, 1, '', '', true, 0, false, true, 5, 'M', true);
                } elseif (preg_match('/^\d+\.\s+/', $line)) {
                    // Format numbered lists
                    $pdf->SetFont('helvetica', 'B', $fontSize);
                    $pdf->SetTextColor(0, 153, 51); // Green color
                    $pdf->MultiCell(0, 5, trim($line), 0, 'L', 0, 1, '', '', true, 0, false, true, 5, 'M', true);
                } elseif (preg_match('/\*\*(.*?)\*\*/', $line)) {
                    // Format bold text
                    $pdf->SetFont('helvetica', 'B', $fontSize);
                    $pdf->SetTextColor(255, 0, 0); // Red color
                    $pdf->MultiCell(0, 5, trim($line, '*'), 0, 'L', 0, 1, '', '', true, 0, false, true, 5, 'M', true);
                } else {
                    // Format normal text
                    $pdf->SetFont('helvetica', '', $fontSize);
                    $pdf->SetTextColor(0, 0, 0); // Black color
                    $pdf->MultiCell(0, 5, $line, 0, 'L', 0, 1, '', '', true, 0, false, true, 5, 'M', true);
                }
            }
            $pdf->Ln(1);
        }

        $pdf->Output($outputPath, 'F');
    }
}
