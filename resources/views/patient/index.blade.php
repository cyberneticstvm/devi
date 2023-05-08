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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Patient Management/</span> Patient Register</h4>
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
                            <div class="text-end"><a href="/patient/create/{{0}}" type="button" class="btn btn-success"><span class="tf-icons bx bx-plus me-1"></span>Add Record</a></div>
                            <div class="card-datatable table-responsive pt-0">
                                <table class="datatable-basic table table-bordered table-sm">
                                    <thead><tr><th>SL No</th><th>Patient Name</th><th>Age</th><th>Gender</th><th>Mobile Number</th><th>Place</th><th>Edit</th><th>Delete</th></tr></thead>
                                    <tbody>
                                        @php $c = 1; @endphp
                                        @forelse($patients as $key => $patient)
                                            <tr>
                                                <td>{{ $c++ }}</td>
                                                <td>{{ $patient->name }}</td>
                                                <td>{{ $patient->age }}</td>
                                                <td>{{ $patient->gender }}</td>
                                                <td>{{ $patient->mobile }}</td>
                                                <td>{{ $patient->place }}</td>
                                                <td class="text-center"><a href="/patient/edit/{{ encrypt($patient->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('patient.delete', $patient->id) }}">
                                                        @csrf 
                                                        @method("DELETE")
                                                        <button type="submit" class="border no-border" onclick="javascript: return confirm('Are you sure want to delete this record?');"><i class="fa fa-times text-danger"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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