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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Branch Management/</span> Update Branch</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('branch.update', $branch->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Branch Name </label>
                                    {!! Form::text('name', $branch->name, array('placeholder' => 'Branch Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Branch Code </label>
                                    {!! Form::text('code', $branch->code, array('placeholder' => 'Branch Code','class' => 'form-control')) !!}
                                    @error('code')
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">GSTIN </label>
                                    {!! Form::text('gstin', $branch->gstin, array('placeholder' => 'GSTIN','class' => 'form-control')) !!}
                                    @error('gstin')
                                    <small class="text-danger">{{ $errors->first('gstin') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label req">Branch Address </label>
                                    {!! Form::text('address', $branch->address, array('placeholder' => 'Branch Address','class' => 'form-control')) !!}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Email </label>
                                    {!! Form::email('email', $branch->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Mobile </label>
                                    {!! Form::text('mobile', $branch->mobile, array('placeholder' => 'Mobile','class' => 'form-control', 'maxlength' => 10)) !!}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Invoice Starts With </label>
                                    {!! Form::number('invoice_starts_with', $branch->invoice_starts_with, array('placeholder' => '0','class' => 'form-control')) !!}
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label req">Credit Limit </label>
                                    {!! Form::number('credit_limit', $branch->credit_limit, array('placeholder' => '0.00','class' => 'form-control', 'step' => 'any')) !!}
                                    @error('credit_limit')
                                    <small class="text-danger">{{ $errors->first('credit_limit') }}</small>
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