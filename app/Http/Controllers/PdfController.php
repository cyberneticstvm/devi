<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use PDF;
use QrCode;

class PdfController extends Controller
{
    public function opt($id){
        $consultation = Consultation::with('patient', 'doctor', 'branch')->findOrFail(decrypt($id));
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate(qrCodeText()));
        $pdf = PDF::loadView('/backend/pdf/opt', compact('consultation', 'qrcode'));
	    return $pdf->stream($consultation->mrn.'.pdf');
    }

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

    public function medicalRecord($id){
        $mrecord = MedicalRecord::with('consultation')->findOrFail(decrypt($id));
        $pdf = PDF::loadView('/backend/pdf/medical_record', compact('mrecord'));
	    return $pdf->stream($mrecord->consultation->mrn.'.pdf');
    }
}
