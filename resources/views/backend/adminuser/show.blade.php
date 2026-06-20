@extends('backend.layouts.layout')
@section('content')


<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Admin Users</h4>
                <h6>Manage your Admin Panel Users</h6>
            </div>
            <div class="page-btn">
                <a href="{{route('admin.user.add')}}" class="btn btn-added"><img src="{{asset('backend/assets/img/icons/plus.svg')}}"
                        alt="img">Add Admin User</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">         
            

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                
                                <th>Image</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminusers as $user)
                            <tr>
                               
                                <td>
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/customer/customer1.jpg') }}" alt="profile image" style="width:60px; height:60px; border-radius:100px;">
                                    </a>
                                </td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->status == '1')
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="me-3">
                                        <img src="{{asset('backend/assets/img/icons/edit.svg')}}" alt="edit">
                                    </a>
                                    @if($user->username == 'superadmin')
                                   <span class="badge rounded-pill bg-info">Supeadmin</span>
                                    @else
                                    
                                    <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}"onclick="return confirm('Are You Sure to permanently delete this?')" class="me-3 " >
                                        <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                    </a>
                                    @endif
                                    
                                    
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>

        

    </div>
</div>

@endsection
