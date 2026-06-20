@extends('backend.layouts.layout')
@section('title', 'Assign Permissions to Roles - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Roles and permissions</h4>
            </div>
            <div class="page-btn">

            </div>
            <div class="page-btn">
                <a href="{{ route('admin.roles_permissions.create') }}" class="btn btn-added"><img
                        src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Assign</a>
            </div>

        </div>


        <div class="card">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                            <tr>
                                <td>{{ $item->name }} </td>                               
                                                  
                                <td>
                                    <a href="
                                            {{ route('admin.roles_permissions.edit', $item->id) }}
                                             " class="me-3">
                                        <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                    </a>

                                    <form id="deleteCat-{{ $item->id }}" action="
                                                {{ route('admin.roles_permissions.delete', $item->id) }}
                                                 " method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>

                                    <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCat-{{ $item->id }}').submit(); } return false;" class="me-3">
                                        <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                    </a>
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