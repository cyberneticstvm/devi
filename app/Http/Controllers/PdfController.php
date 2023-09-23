<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use PDF;
use QrCode;

class PdfController extends Controller
{
    public function prescription($id){
        $consultation = Consultation::with('patient', 'doctor', 'branch')->findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate(qrCodeText()));
        $pdf = PDF::loadView('/backend/pdf/prescription', compact('consultation', 'qrcode'));
	    return $pdf->stream($consultation->mrn.'.pdf');
    }

    public function cReceipt($id){
        $consultation = Consultation::with('patient', 'doctor', 'branch')->findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate(qrCodeText()));
        $pdf = PDF::loadView('/backend/pdf/consultation_receipt', compact('consultation', 'qrcode'));
	    return $pdf->stream($consultation->mrn.'.pdf');
    }
}
