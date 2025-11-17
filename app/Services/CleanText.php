<?php

namespace App\Services;

class CleanText
{
    public function clean(string $text): string
    {
        $cleanText = "";

        $cleanText = strip_tags($text);
        $cleanText = str_replace(['**', '*', '_', '`', '#', '[', ']', '%', '&', '$', '@', '^', '<', '/'], '', $cleanText);

        $cleanText = str_replace(array("\n", "\r"), ' ', $cleanText);

        $cleanText = preg_replace('/\s+/', ' ', $cleanText);

        $cleanText = preg_replace('/[[:cntrl:]]/', '', $cleanText);
        $cleanText = preg_replace('/[^\x20-\x7E\xA0-\xFF]/', '', $cleanText);

        $cleanText = trim($cleanText);

        return $cleanText;
    }
}
