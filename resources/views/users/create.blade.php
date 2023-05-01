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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">User Management/</span> Create User</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('user.create') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Full Name </label>
                                    {!! Form::text('name', null, array('placeholder' => 'Full Name','class' => 'form-control')) !!}
                                    @error('name')
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Username </label>
                                    {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control')) !!}
                                    @error('username')
                                        <small class="text-danger">{{ $errors->first('username') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Email </label>
                                    {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    @error('email')
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Password </label>
                                    <input type="password" name="password" class="form-control" placeholder="******" />
                                    @error('password')
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Role </label>
                                    {!! Form::select('roles', $roles, null, array('placeholder' => 'Select','class' => 'form-control select2')) !!}
                                    @error('roles')
                                        <small class="text-danger">{{ $errors->first('roles') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label req">Branch </label>
                                    {!! Form::select('branch[]', $branches, null, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => 'Select Branch')) !!}
                                    @error('branch')
                                        <small class="text-danger">{{ $errors->first('branch') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Status </label>
                                    <select class="form-control select2" name="status" data-placeholder="Select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $errors->first('status') }}</small>
                                    @enderror
                                </div>
                                <div class="divider my-4">
                                    <div class="divider-text fw-bold text-primary">If the user is Doctor, provide below details</div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Doctor Code </label>
                                    {!! Form::text('doctor_code', null, array('placeholder' => 'Doctor Code','class' => 'form-control')) !!}
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Doctor Designation </label>
                                    {!! Form::text('doctor_designation', null, array('placeholder' => 'Doctor Designation','class' => 'form-control')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Doctor Fee </label>
                                    {!! Form::number('doctor_fee', null, array('placeholder' => '0.00','class' => 'form-control', 'step' => 'any')) !!}
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