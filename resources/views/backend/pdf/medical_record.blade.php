@extends("backend.pdf.base")
@section("pdfcontent")
<div class="row">
    <div class="col text-center">
        <h3>{{ title() }}</h3>
        {{ $mrecord->consultation->branch->name }}, {{ $mrecord->consultation->branch->address }}, {{ $mrecord->consultation->branch->phone }}
    </div>
</div>
<div class="row">
    <div class="col">
        <h4 class="text-center">MEDICAL RECORD</h4>
        <table class="table bordered" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr><td width="40%">Name: {{ strtoupper($mrecord->consultation->patient->name) }}</td><td>ID: {{ $mrecord->consultation->patient->patient_id }}</td><td>MRN: {{ $mrecord->consultation->mrn }}</td></tr>
                <tr><td>Age: {{ $mrecord->consultation->patient->age }}</td><td>Contact: {{ $mrecord->consultation->patient->mobile }}</td><td>Doctor: {{ $mrecord->consultation->doctor->name }}</td></tr>
                <tr><td colspan="2">Address: {{ $mrecord->consultation->patient->place }}</td><td>Date: {{ $mrecord->created_at->format('d, M Y h:i A') }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-30">
        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($mrecord->consultation->mrn , 'C39', 1, 30, array(110, 38, 14))}}" alt="barcode" />
    </div>
</div>
@endsection