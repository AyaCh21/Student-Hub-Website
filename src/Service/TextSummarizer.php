<?php
// src/Service/TextSummarizer.php
namespace App\Service;

class TextSummarizer
{
    public function summarize(array $pages, $maxElements = 5)
    {
        $repeatedContent = $this->identifyRepeatedContent($pages);

        $summary = [];

        foreach ($pages as $pageIndex => $page) {

            $page = str_replace($repeatedContent, '', $page);


            $lines = explode("\n", $page);
            $elements = [];

            foreach ($lines as $line) {
                if (preg_match('/^(\s*[\*\-\•]\s+)/', $line)) {

                    $elements[] = ['type' => 'bullet', 'content' => $line];
                } elseif (preg_match('/^\d+\.\s+/', $line)) {

                    $elements[] = ['type' => 'numbered', 'content' => $line];
                } elseif (preg_match('/\*\*(.*?)\*\*/', $line)) {

                    $elements[] = ['type' => 'bold', 'content' => $line];
                }

                if (count($elements) >= $maxElements) {
                    break;
                }
            }

            if (count($elements) < $maxElements) {
                $sentences = preg_split('/(?<=[.!?])\s+/', $page, -1, PREG_SPLIT_NO_EMPTY);
                foreach ($sentences as $sentence) {
                    $elements[] = ['type' => 'sentence', 'content' => $sentence];
                    if (count($elements) >= $maxElements) {
                        break;
                    }
                }
            }

            foreach ($elements as $element) {
                if ($element['type'] === 'bullet' || $element['type'] === 'numbered') {
                    $summary[] = $element['content'];
                } elseif ($element['type'] === 'bold') {
                    $summary[] = '**' . $element['content'] . '**';
                } else {
                    $summary[] = $element['content'];
                }
            }
        }

        return implode("\n\n", $summary);
    }

    private function identifyRepeatedContent(array $pages)
    {
        $contentCounts = [];
        foreach ($pages as $page) {
            $lines = explode("\n", $page);
            foreach ($lines as $line) {
                if (!isset($contentCounts[$line])) {
                    $contentCounts[$line] = 0;
                }
                $contentCounts[$line]++;
            }
        }

        $repeatedContent = [];
        foreach ($contentCounts as $line => $count) {
            if ($count > 1) {
                $repeatedContent[] = $line;
            }
        }

        return implode("\n", $repeatedContent);
    }
}
