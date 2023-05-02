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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Product Management/</span> Create Product</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header">
                        @include("message")
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.create') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label req">Product Name </label>
                                    {!! Form::text('name', null, array('placeholder' => 'Product Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Category Name </label>
                                    {!! Form::select('category_id', $categories, null, array('placeholder' => 'Category Name','class' => 'form-control select2', 'data-placeholder' => 'Select Category')) !!}
                                    @error('category_id')
                                    <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Subcategory Name </label>
                                    {!! Form::select('subcategory_id', $subcategories, null, array('placeholder' => 'Subcategory Name','class' => 'form-control select2', 'data-placeholder' => 'Select Subcategory')) !!}
                                    @error('subcategory_id')
                                    <small class="text-danger">{{ $errors->first('subcategory_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Price </label>
                                    {!! Form::number('price', null, array('placeholder' => '0.00','class' => 'form-control', 'step' => 'any')) !!}
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Notes </label>
                                    {!! Form::textarea('notes', null, array('placeholder' => 'Notes','class' => 'form-control', 'rows' => '3')) !!}
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