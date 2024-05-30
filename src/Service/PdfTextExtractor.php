<?php
namespace App\Service;

use Smalot\PdfParser\Parser;

class PdfTextExtractor
{
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function extractTextFromPath($pdfPath)
    {
        $pdf = $this->parser->parseFile($pdfPath);
        return $this->extractTextFromPdf($pdf);
    }

    public function extractTextFromBlob($pdfBlob)
    {
        $pdf = $this->parser->parseContent($pdfBlob);
        return $this->extractTextFromPdf($pdf);
    }

    private function extractTextFromPdf($pdf)
    {
        $pages = $pdf->getPages();
        $textPages = [];
        foreach ($pages as $page) {
            $textPages[] = $this->removeUnwantedContent($page->getText());
        }
        return $textPages;
    }

    private function removeUnwantedContent($text)
    {
        $lines = explode("\n", $text);
        $filteredLines = array_filter($lines, function($line) {
            return !preg_match('/\b(?:faculty of engineering technology|Figure|Image|Diagram|Photo|Table|Chart)\b/i', $line);
        });
        return implode("\n", $filteredLines);
    }
}
