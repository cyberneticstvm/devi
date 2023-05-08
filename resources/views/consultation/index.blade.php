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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Consultaton Management/</span> Consultation Register</h4>
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
                            <div class="card-datatable table-responsive pt-0">
                                <table class="datatable-basic table table-bordered table-sm">
                                    <thead><tr><th>SL No</th><th>Mrn</th><th>Patient Name</th><th>Contact</th><th>Place</th><th>Doctor</th><th>Purpose of Visit</th><th>Edit</th><th>Delete</th></tr></thead>
                                    <tbody>
                                        @php $c = 1; @endphp
                                        @forelse($consultations as $key => $con)
                                            <tr>
                                                <td>{{ $c++ }}</td>
                                                <td>{{ $con->mrn }}</td>
                                                <td>{{ $con->patient->name }}</td>
                                                <td>{{ $con->patient->mobile }}</td>
                                                <td>{{ $con->patient->place }}</td>
                                                <td>{{ $con->doctor->name }}</td>
                                                <td>{{ $con->visitpurpose->name }}</td>
                                                <td class="text-center"><a href="/consultation/edit/{{ encrypt($con->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('consultation.delete', $con->id) }}">
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