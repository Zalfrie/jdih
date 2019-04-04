<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \fpdi\FPDI;
use App\Plugin\PDFWatermark;
use App\Plugin\PDFWatermarker;

class ReferensiWatermarkController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        if ($request->isMethod('post') && $request->file('image') && $request->file('image')->isValid()) {
            $fileName = \Config::get('constants.public_upload').'watermark.pdf';
            $pdf=new FPDI();
            $pdf->AddPage();
            $pdf->SetFont('Arial','',12);
            $pdf->setPdfVersion('1.4');
            $txt="Kementerian BUMN. Kementerian BUMN. Kementerian BUMN. Kementerian BUMN.\n\n";
            for($i=0;$i<25;$i++) 
                $pdf->MultiCell(0,5,$txt,0,'J');
            $pdf->Output($fileName, 'F');
            
            $imgPath = \Config::get('constants.public_upload').'watermark.png';
            $img = \Image::make($_FILES['image']['tmp_name']);
            if (!empty($request->greyscale)){
                $img->greyscale();
            }
            $img->opacity($request->opacity);
            $img->save($imgPath);
                
            $fileImage = $imgPath;
            $watermark = new PDFWatermark($fileImage); 
    		$watermarker = new PDFWatermarker($fileName, $fileName, $watermark); 
    		$watermarker->setWatermarkPosition('center');
    		$watermarker->watermarkPdf('F');
        }
        return view('administrasi.referensi.watermark.index', []);
    }
    
    public function exwatermark(Request $request)
    {
        $fileName = \Config::get('constants.public_upload').'watermark.pdf';
        
        return \Response::make(file_get_contents($fileName), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="watermark.pdf"'
        ]);
    }
}
