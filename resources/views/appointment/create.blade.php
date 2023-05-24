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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Appointment Management/</span> Create Appointment</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        @include("message")
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('appointment.create') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Patient Name </label>
                                    {!! Form::text('name', null, array('placeholder' => 'Patient Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Age </label>
                                    {!! Form::number('age', null, array('placeholder' => '0','class' => 'form-control')) !!}
                                    @error('age')
                                    <small class="text-danger">{{ $errors->first('age') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Gender </label>
                                    {!! Form::select('gender', array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), null, array('class' => 'form-control', 'placeholder'=>'Select')) !!}
                                    @error('gender')
                                    <small class="text-danger">{{ $errors->first('gender') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Place </label>
                                    {!! Form::text('place', null, array('placeholder' => 'Place','class' => 'form-control')) !!}
                                    @error('place')
                                    <small class="text-danger">{{ $errors->first('place') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Mobile </label>
                                    {!! Form::text('mobile', null, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength' => 10)) !!}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Branch </label>
                                    {!! Form::select('branch_id', $branches, null, array('class' => 'form-control', 'placeholder'=>'Select')) !!}
                                    @error('branch_id')
                                    <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Doctor </label>
                                    {!! Form::select('doctor_id', $doctors, null, array('class' => 'form-control', 'placeholder'=>'Select')) !!}
                                    @error('doctor_id')
                                    <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Appointment Date </label>
                                    {!! Form::date('appointment_date', null, array('placeholder' => 'Date','class' => 'form-control')) !!}
                                    @error('appointment_date')
                                    <small class="text-danger">{{ $errors->first('appointment_date') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @php $stime = Session::get('stime'); $etime = Session::get('etime'); $ctime = Session::get('ctime'); $apps = Session::get('apps'); @endphp
                                    <h5>Available Slots</h5>
                                </div>
                                @if($ctime)
                                    @for($i=$stime; $i<=$etime; $i++)
                                        @for($j=0; $j<=60-$ctime; $j+=$ctime)
                                            @php $val = $i.':'.$j; $val = date("h:i A", strtotime($val));
                                            $time = Carbon\Carbon::parse($val)->toTimeString(); 
                                            $dis = $apps->where('appointment_time', $time)->first(); 
                                            $booked = ($dis) ? "booked" : "";
                                            $disabled = ($dis) ? "disabled" : "";
                                            @endphp
                                            <div class="col-md-1 slot {{ $booked }}">
                                                {{ $val }}
                                                <input type="radio" name="app_time" value="{{ $val }}" {{ $disabled }} />
                                            </div>
                                        @endfor
                                    @endfor
                                @endif
                            </div>                            
                            <div class="row">
                                <div class="col text-end demo-inline-spacing">
                                    <button type="submit" class="btn btn-info btn-submit">
                                        <span class="tf-icons bx bx-user me-1"></span>Show Slots
                                    </button>
                                    <button type="submit" name="action" value="submit" class="btn btn-primary btn-submit">
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