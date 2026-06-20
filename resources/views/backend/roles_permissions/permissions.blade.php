@extends('backend.layouts.layout')
@section('title', 'Admin Permissions - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Permissions</h4>
            </div>
        </div>

        <div class="row">
            {{-- Form Section: Handles both Add and Edit --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ isset($editingPermission) ? route('admin.permissions.update', $editingPermission->id) : route('admin.permissions.store') }}">
                            @csrf
                            @if(isset($editingPermission))
                            @method('PUT')
                            @endif

                            {{-- Permission Name --}}
                            <div class="form-group">
                                <label>Permission Name*</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ old('name', $editingPermission->name ?? '') }}"
                                    name="name"
                                    required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Group Name Selection --}}
                            <div class="form-group">
                                <label class="form-label">Group Name*</label>
                                <select name="group_name" class="form-control" required>
                                    <option value="" selected disabled>Select One</option>
                                    @php
                                    $groups = ['categories', 'brands', 'coupons', 'products', 'product_attributes', 'manage_orders', 'manage_site', 'system_admins', 'roles_permissions'];
                                    @endphp

                                    @foreach($groups as $group)
                                    <option value="{{ $group }}"
                                        {{ (old('group_name', $editingPermission->group_name ?? '') == $group) ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $group)) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('group_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">
                                {{ isset($editingPermission) ? 'Update Permission' : 'Add Permission' }}
                            </button>

                            @if(isset($editingPermission))
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered datanew">
                                <thead>
                                    <tr class="table-light">
                                        <th width="70%">Permission</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                </thead>
                                @foreach ($permissions as $groupName => $groupPermissions)
                                <tbody>
                                    @foreach ($groupPermissions as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.permissions.edit', $item->id) }}" class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                            </a>

                                            <a href="javascript:void(0);"
                                                onclick="if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                            </a>

                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('admin.permissions.delete', $item->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endforeach
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection