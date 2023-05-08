@extends("base")
@section("content")
<!-- Layout container -->
<div class="layout-page">
    <!-- Content wrapper -->
    <div class="content-wrapper">
    @include("nav")

    <!-- Content -->

    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Consultation Management/</span> Create Consultation</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('consultation.save') }}">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment_id }}" />
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}" />
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Patient Name </label>
                                    {!! Form::text('name', $patient->name, array('placeholder' => 'Patient Name','class' => 'form-control', 'readonly')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Age </label>
                                    {!! Form::number('age', $patient->age, array('placeholder' => '0','class' => 'form-control', 'readonly')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Gender </label>
                                    <select class="form-control select2" name="gender" readonly>
                                        <option value="">Select</option>
                                        <option value="Male" {{ ($patient->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ ($patient->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ ($patient->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Place </label>
                                    {!! Form::text('place', $patient->place, array('placeholder' => 'Place','class' => 'form-control', 'readonly')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Mobile </label>
                                    {!! Form::text('mobile', $patient->mobile, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength' => 10, 'readonly')) !!}                                    
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Purpose of Visit </label>
                                    {!! Form::select('purpose_of_visit', $ctypes->pluck('name', 'id'), null, array('class' => 'form-control select2', 'data-placeholder' => 'select')) !!}
                                    @error('purpose_of_visit')
                                    <small class="text-danger">{{ $errors->first('purpose_of_visit') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Doctor </label>
                                    {!! Form::select('doctor_id', $doctors->pluck('name', 'id'), null, array('class' => 'form-control select2', 'data-placeholder' => 'select')) !!}
                                    @error('doctor_id')
                                    <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Coupon Code </label>
                                    {!! Form::text('coupon_code', null, array('placeholder' => 'Coupon Code','class' => 'form-control')) !!}                                    
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Surgery Advised </label>
                                    <select class="form-control select2" name="advised_cataract_surgery">
                                        <option value="">Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Surgery Urgent </label>
                                    <select class="form-control select2" name="surgery_urgent">
                                        <option value="">Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Surgery Advised Date </label>
                                    {!! Form::date('surgery_advised_on', null, array('placeholder' => 'Coupon Code','class' => 'form-control')) !!}                                    
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Doctor Fee Payment Mode </label>
                                    {!! Form::select('doctor_fee_payment_method', $pmodes->pluck('name', 'id'), null, array('class' => 'form-control select2', 'data-placeholder' => 'select')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Status </label>
                                    <select class="form-control select2" name="status">
                                        <option value="">Select</option>
                                        <option value="0" selected>Active</option>
                                        <option value="1">Cancelled</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col text-end demo-inline-spacing">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <span class="tf-icons bx bx-check me-1"></span>Save
                                    </button>
                                    <button type="button" onclick="javascript:window.history.back();" class="btn btn-danger">
                                        <span class="tf-icons bx bx-redo me-1"></span>Cancel
                                    </button>
                                </div>
                            </div>                
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Content -->
    @include("footer")
</div>

<!--/ Layout container -->
@endsection