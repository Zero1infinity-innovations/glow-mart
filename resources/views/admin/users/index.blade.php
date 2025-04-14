@extends('admin.layouts.master')

@push('title')
    User List
@endpush

@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <h6 class="mb-0 text-uppercase">User List</h6>
        </div>
        {{-- <div class="col-6 text-end px-0 px-lg-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-3">
                <i class='bx bx-plus'></i> Add User
            </a>
        </div> --}}
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered no-footer">
                    <thead class="table-light">
                        <tr>
                            <th>S No.</th>
                            {{-- <th>Profile</th> --}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Pincode</th>
                            <th>Address</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp

                        @if ($data->count() > 0)
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $sn++ }}</td>
                                    {{-- <td>
                                        @if ($user->profile_image)
                                            <img src="{{ asset('uploads/profile/' . $user->profile_image) }}" alt="Profile"
                                                width="40" height="40"
                                                style="object-fit: cover; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('images/default-user.png') }}" alt="Default" width="40"
                                                height="40" style="object-fit: cover; border-radius: 50%;">
                                        @endif
                                    </td> --}}
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                                    <td>{{ $user->city ?? 'N/A' }}</td>
                                    <td>{{ $user->state ?? 'N/A' }}</td>
                                    <td>{{ $user->pincode ?? 'N/A' }}</td>
                                    <td>{{ $user->address ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">No users found.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
