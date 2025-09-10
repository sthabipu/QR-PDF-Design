<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Services\PdfService;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index()
    {
        // Step 1: Upload view
        return view('qr.index');
    }

    public function process(Request $request, PdfService $svc)
    {
        // Validate upload (<= 50MB)
        $request->validate([
            'pdf' => ['required','file','mimetypes:application/pdf','max:51200'],
            'cols' => ['nullable','integer','min:1','max:10'],
            'rows' => ['nullable','integer','min:1','max:20'],
            'label_w' => ['nullable','numeric'],
            'label_h' => ['nullable','numeric'],
            'gap_x' => ['nullable','numeric'],
            'gap_y' => ['nullable','numeric'],
            'margin_left' => ['nullable','numeric'],
            'margin_top' => ['nullable','numeric'],
        ]);

        // --- ensure upload dir exists (Windows friendly) ---
        $uploadDir = storage_path('app/uploads');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // --- move uploaded file to a stable absolute path ---
        $uploadedFile = $request->file('pdf');
        $srcName = Str::uuid().'.'.$uploadedFile->getClientOriginalExtension();
        $srcPath = $uploadDir.DIRECTORY_SEPARATOR.$srcName;
        $uploadedFile->move($uploadDir, $srcName);

        if (!file_exists($srcPath)) {
            abort(500, "Upload failed. File not found at: {$srcPath}");
        }

        // --- output path (public via storage:link) ---
        $outDir = storage_path('app/public/qrsheets');
        if (!is_dir($outDir)) {
            mkdir($outDir, 0777, true);
        }
        $outPath = $outDir.DIRECTORY_SEPARATOR.Str::uuid().'.pdf';

        // Layout overrides (optional)
        $cfg = array_filter([
            'cols'        => $request->input('cols'),
            'rows'        => $request->input('rows'),
            'label_w'     => $request->input('label_w'),
            'label_h'     => $request->input('label_h'),
            'gap_x'       => $request->input('gap_x'),
            'gap_y'       => $request->input('gap_y'),
            'margin_left' => $request->input('margin_left'),
            'margin_top'  => $request->input('margin_top'),
        ], fn($v) => !is_null($v));

        // Generate the 40-up PDF
        $svc->make($srcPath, $outPath, $cfg);

        // Step 3: Download view
        $downloadUrl = asset('storage/qrsheets/'.basename($outPath));
        return view('qr.done', compact('downloadUrl'));
    }
}
