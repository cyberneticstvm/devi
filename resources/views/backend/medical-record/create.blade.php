@extends("backend.base")
@section("content")
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Medical Record</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">                                       
                            <svg class="stroke-icon">
                                <use href="{{ asset('/backend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg></a></li>
                        <li class="breadcrumb-item">Medical Record</li>
                        <li class="breadcrumb-item active">Craete</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                    <h5>Medical Record</h5><span>Create Medical Record</span>
                    </div>
                    <div class="card-body">
                        <div class="card-wrapper">
                            <form class="row g-3" method="post" action="{{ route('mrecord.save') }}">
                                @csrf
                                <input type="hidden" name="consultation_id" value="{{ encrypt($consultation->id) }}" />
                                <div class="col-md-3">
                                    <label class="form-label">Patient Name</label>
                                    {{ html()->text($name = 'pname', $value = $consultation->patient->name)->class('form-control')->attribute('disabled') }}
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Patient ID</label>
                                    {{ html()->text($name = 'pid', $value = $consultation->patient->patient_id)->class('form-control')->attribute('disabled') }}
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">MRN</label>
                                    {{ html()->text($name = 'mrn', $value = $consultation->mrn)->class('form-control')->attribute('disabled') }}
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Doctor</label>
                                    {{ html()->text($name = 'pmobile', $value = $consultation->doctor->name)->class('form-control')->attribute('disabled') }}
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label req">Symptoms</label><small>(Allowed Multiple)</small>
                                    {{ html()->text($name = 'symptoms', $value = '')->class('form-control')->attribute('data-role', 'tagsinput')->placeholder('Symptoms') }}
                                    @error('symptoms')
                                    <small class="text-danger">{{ $errors->first('symptoms') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Patient History</label>
                                    {{ html()->textarea($name = 'patient_history', $value = '')->class('form-control')->attribute('rows', 5)->placeholder('Patient History if any') }}
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Is allergic to any drugs?</label>
                                    {{ html()->textarea($name = 'allergic_drugs', $value = '')->class('form-control')->attribute('rows', 5)->placeholder('Details') }}
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label req">Diagnoses</label><small>(Allowed Multiple)</small>
                                    {{ html()->text($name = 'diagnosis', $value = '')->class('form-control')->attribute('data-role', 'tagsinput')->placeholder('Diagnosis') }}
                                    @error('diagnosis')
                                    <small class="text-danger">{{ $errors->first('diagnosis') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label req">Doctor Recommondations / Advice</label>
                                    {{ html()->textarea($name = 'doctor_recommondation', $value = '')->class('form-control')->attribute('rows', 5)->placeholder('Doctor Recommondations / Advice') }}
                                    @error('doctor_recommondation')
                                    <small class="text-danger">{{ $errors->first('doctor_recommondation') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 table-responsive">
                                    <label class="form-label fw-bold">VISION</label>
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr><th>EYE</th><th>SPH</th><th>CYL</th><th>AXIS</th><th>ADD</th><th>VA</th><th>NV</th></tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>RE</td>
                                                <td><input type="text" name="re_sph" class="form-control form-control-sm text-center" maxlength="6" placeholder="SPH" value="{{ old('re_sph') }}"></td>
                                                <td><input type="text" name="re_cyl" class="form-control form-control-sm text-center" maxlength="6" placeholder="CYL" value="{{ old('re_cyl') }}"></td>
                                                <td><input type="text" name="re_axis" class="form-control form-control-sm text-center" maxlength="6" placeholder="AXIS" value="{{ old('re_axis') }}"></td>
                                                <td><input type="text" name="re_add" class="form-control form-control-sm text-center" maxlength="6" placeholder="ADD" value="{{ old('re_add') }}"></td>
                                                <td><input type="text" name="re_va" class="form-control form-control-sm text-center" maxlength="6" placeholder="VA" value="{{ old('re_va') }}"></td>
                                                <td><input type="text" name="re_nv" class="form-control form-control-sm text-center" maxlength="6" placeholder="NV" value="{{ old('re_nv') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>LE</td>
                                                <td><input type="text" name="le_sph" class="form-control form-control-sm text-center" maxlength="6" placeholder="SPH" value="{{ old('le_sph') }}"></td>
                                                <td><input type="text" name="le_cyl" class="form-control form-control-sm text-center" maxlength="6" placeholder="CYL" value="{{ old('le_cyl') }}"></td>
                                                <td><input type="text" name="le_axis" class="form-control form-control-sm text-center" maxlength="6" placeholder="AXIS" value="{{ old('le_axis') }}"></td>
                                                <td><input type="text" name="le_add" class="form-control form-control-sm text-center" maxlength="6" placeholder="ADD" value="{{ old('le_add') }}"></td>
                                                <td><input type="text" name="le_va" class="form-control form-control-sm text-center" maxlength="6" placeholder="VA" value="{{ old('le_va') }}"></td>
                                                <td><input type="text" name="le_nv" class="form-control form-control-sm text-center" maxlength="6" placeholder="NV" value="{{ old('le_nv') }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                                <div class="col-md-2">
                                    <label class="form-label">Surgery Advised?</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" role="switch" name="surgery_advised" value="1">
                                    </div>
                                </div>                               
                                <div class="col-md-3">
                                    <label class="form-label">Next Review Date</label>
                                    {{ html()->date($name = 'review_date', $value = old('review_date'))->class('form-control')->placeholder(date('Y-m-d')) }}
                                </div>                                
                                <div class="col-12 text-end">
                                    <button class="btn btn-secondary" onClick="window.history.back()" type="button">Cancel</button>
                                    <button class="btn btn-submit btn-success" type="submit">Save</button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection