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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Category Management/</span> Update Category</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('category.update', $category->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Category Name </label>
                                    {!! Form::text('name', $category->name, array('placeholder' => 'Category Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
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