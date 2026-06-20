@extends('backend.layouts.layout')
@section('title', 'Admin Roles - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Roles</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        <form method="POST" action="{{ isset($editingRole) ? route('admin.roles.update', $editingRole->id) : route('admin.roles.store') }}">
                            @csrf
                        @if(isset($editingRole))
        @method('PUT')
    @endif
                            <div class="form-group">
                                <label>Role Name</label>
                                <input type="text" class="form-control" value="{{ old('name', $editingRole->name ?? '') }}" id="role" name="name" required>
                                <div class="text-danger">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-2"> {{ isset($editingRole) ? 'Update Role' : 'Add Role' }}</button>
                                @if(isset($editingRole))
                                    <a href="{{ route('admin.roles.index') }}"
                                       class="btn btn-secondary mt-2">
                                        Cancel
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $item)
                                    <tr>
                                        <td>{{ $item->name }} </td>

                                        <td>
                                            <a href="
                                            {{ route('admin.roles.edit', $item->id) }}
                                             " class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                            </a>

                                            <form id="deleteCat-{{ $item->id }}" action="
                                                {{ route('admin.roles.delete', $item->id) }}
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

    </div>
</div>

@endsection