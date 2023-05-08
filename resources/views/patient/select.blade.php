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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Patient Management/</span> Select Patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header">
                            @include("message")
                        </div>
                        <div class="card-body">
                            <p class="text-info">Found existing records in the database. Please select an option and proceed.</p>
                            <form method="post" action="{{ route('patient.proceed') }}">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment_id }}" />
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table table-bordered table-sm">
                                        <thead><tr><th>SL No</th><th>Patient Name</th><th>Contact</th><th>Place</th><th>Select</th></tr></thead>
                                        <tbody>
                                            @php $c = 1 @endphp
                                            @forelse($patients as $key => $patient)
                                                <tr>
                                                    <td>{{ $c++ }}</td>
                                                    <td>{{ $patient->name }}</td>
                                                    <td>{{ $patient->mobile }}</td>
                                                    <td>{{ $patient->place }}</td>
                                                    <td class="text-center"><input class="form-check-input" type="radio" name="rad" value="{{ $patient->id }}" checked/></td>
                                                </tr>
                                            @empty
                                            @endforelse
                                            <tr><td colspan="4" class="text-end">Continue as a new Patient</td><td class="text-center"><input class="form-check-input" type="radio" name="rad" value="0" /></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col text-end demo-inline-spacing">
                                        <button type="submit" class="btn btn-primary btn-submit">
                                            <span class="tf-icons bx bx-check me-1"></span>Proceed
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
    </div>
    <!--/ Content -->
    @include("footer")
</div>

<!--/ Layout container -->
@endsection