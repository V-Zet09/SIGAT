<?php

namespace App\Jobs;

use App\Models\Informe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class GenerarPdfInforme implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $informe;

    public function __construct(Informe $informe)
    {
        $this->informe = $informe;
    }

    public function handle()
    {
        try {
            $informe = $this->informe;
            $html = view('informes.pdf', compact('informe'))->render();

            $dirPath = storage_path('app/public/pdfs');
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
                chmod($dirPath, 0777);
            }

            $pdfPath = 'pdfs/informe_' . $informe->id . '_' . time() . '.pdf';
            $fullPath = storage_path('app/public/' . $pdfPath);

            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->WriteHTML($html);
            $mpdf->Output($fullPath, 'F');

            chmod($fullPath, 0777);
            $informe->update(['pdf_path' => $pdfPath]);

            Log::info('✅ PDF generado: ' . $pdfPath);

        } catch (\Exception $e) {
            Log::error('❌ Error PDF: ' . $e->getMessage());
        }
    }
}
