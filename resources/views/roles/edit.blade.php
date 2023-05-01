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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Roles & Permissions/</span> Update Role</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('role.update', $role->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row mb-3">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label req">Role Name </label>
                                    {!! Form::text('name', $role->name, array('placeholder' => 'Role Name','class' => 'form-control')) !!}
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label req">Permissions </label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                @foreach($permission as $value)
                                    <div class="col-md-2">
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name form-check-input')) }}
                                        {{ $value->name }}</label>
                                    </div>
                                @endforeach
                                @error('permission')
                                    <small class="text-danger mt-1">{{ $errors->first('permission') }}</small>
                                @enderror
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