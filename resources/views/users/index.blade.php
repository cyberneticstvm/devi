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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">User Management/</span> User List</h4>
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
                            <div class="text-end"><a href="/user/create" type="button" class="btn btn-success"><span class="tf-icons bx bx-plus me-1"></span>Add Record</a></div>
                            <div class="card-datatable table-responsive pt-0">
                                <table class="datatable-basic table table-bordered table-sm">
                                    <thead><tr><th>SL No</th><th>Full Name</th><th>Username</th><th>Email</th><th>User Role</th><th>Branches</th><th>Edit</th><th>Delete</th></tr></thead>
                                    <tbody>
                                        @php $c = 1; @endphp
                                        @forelse($users as $key => $user)
                                            <tr>
                                                <td>{{ $c++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->roles->pluck('name')->implode(',') }}</td>
                                                <td>{{ branches()->find($user->branches->pluck('branch_id'))->pluck('name')->implode(', ') }}</td>
                                                <td class="text-center"><a href="/user/edit/{{ encrypt($user->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('user.delete', $user->id) }}">
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