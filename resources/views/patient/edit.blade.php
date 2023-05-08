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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Patient Management/</span> Update Patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('patient.update', $patient->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Patient Name </label>
                                    {!! Form::text('name', $patient->name, array('placeholder' => 'Patient Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Age </label>
                                    {!! Form::number('age', $patient->age, array('placeholder' => '0','class' => 'form-control')) !!}
                                    @error('age')
                                    <small class="text-danger">{{ $errors->first('age') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Gender </label>
                                        <select class="form-control select2" name="gender">
                                            <option value="">Select</option>
                                            <option value="Male" {{ ($patient->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ ($patient->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ ($patient->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                        </select>
                                    @error('gender')
                                    <small class="text-danger">{{ $errors->first('gender') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Place </label>
                                    {!! Form::text('place', $patient->place, array('placeholder' => 'Place','class' => 'form-control')) !!}
                                    @error('place')
                                    <small class="text-danger">{{ $errors->first('place') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Mobile </label>
                                    {!! Form::text('mobile', $patient->mobile, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength' => 10)) !!}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col text-end demo-inline-spacing">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <span class="tf-icons bx bx-check me-1"></span>Update
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