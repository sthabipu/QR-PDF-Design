<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

class PdfService
{
    /**
     * @param string $srcPath  Path to input 1-QR-per-page PDF
     * @param string $destPath Path to output 40-up PDF
     * @param array  $cfg      Optional layout overrides (mm):
     *   cols, rows, label_w, label_h, gap_x, gap_y, margin_left, margin_top
     */
    public function make(string $srcPath, string $destPath, array $cfg = []): void
    {
        // Layout defaults tuned for A4 labels like your diagram
        $cols = $cfg['cols'] ?? 5;
        $rows = $cfg['rows'] ?? 8;

        $labelW = $cfg['label_w'] ?? 30.0;  // mm
        $labelH = $cfg['label_h'] ?? 30.0;  // mm

        $gapX = $cfg['gap_x'] ?? 4.0;       // mm
        $gapY = $cfg['gap_y'] ?? 4.0;       // mm

        $marginLeft = $cfg['margin_left'] ?? 22.0; // mm
        $marginTop  = $cfg['margin_top']  ?? 22.0; // mm

        $pdf = new Fpdi('P', 'mm', 'A4');   // 210 × 297 mm

        // Count pages in source
        $count = $pdf->setSourceFile($srcPath);
        $pageNo = 1;

        while ($pageNo <= $count) {
            $pdf->AddPage();

            for ($r = 0; $r < $rows && $pageNo <= $count; $r++) {
                for ($c = 0; $c < $cols && $pageNo <= $count; $c++, $pageNo++) {
                    $tpl = $pdf->importPage($pageNo, '/MediaBox');

                    // Target position in the grid
                    $x = $marginLeft + $c * ($labelW + $gapX);
                    $y = $marginTop  + $r * ($labelH + $gapY);

                    // Place and scale to the label size
                    $pdf->useTemplate($tpl, $x, $y, $labelW, $labelH, false);
                }
            }
        }

        // Save
        $pdf->Output($destPath, 'F');
    }
}
