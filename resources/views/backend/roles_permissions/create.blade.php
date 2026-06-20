@extends('backend.layouts.layout')
@section('title', 'Assign Permissions to Roles - Raza Mall')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h6>Assign Permissions to Roles</h6>
            </div>
        </div>

        <form method="post" action="{{ route('admin.roles_permissions.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="role">Role*</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="col-lg-12">
                            @error('permissions')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="checkAllPermissions">
                                <label class="form-check-label" for="checkAllPermissions"><strong>Select All Permissions</strong></label>
                            </div>

                            @foreach ($permission_groups as $group)
                            <div class="row mb-4">
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input group-checkbox" id="group-{{ $loop->index }}">
                                        <label class="form-check-label text-primary" for="group-{{ $loop->index }}">
                                            <strong>{{ $group->group_name }}</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    @php
                                    $permissions = App\Models\Admin::getPermissionByGroupName($group->group_name);
                                    @endphp
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]"
                                                    class="form-check-input permission-checkbox"
                                                    id="perm-{{ $permission->id }}"
                                                    value="{{ $permission->id }}"
                                                    data-group="group-{{ $loop->parent->index }}">
                                                <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Handle "Select All Permissions"
        $('#checkAllPermissions').click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        // 2. Handle Group-specific "Select All"
        $('.group-checkbox').click(function() {
            const groupId = $(this).attr('id');
            if ($(this).is(':checked')) {
                $(`input[data-group=${groupId}]`).prop('checked', true);
            } else {
                $(`input[data-group=${groupId}]`).prop('checked', false);
            }
            updateMasterCheckbox();
        });

        // 3. Update parent checkboxes if individual ones are unchecked
        $('.permission-checkbox').click(function() {
            const groupId = $(this).data('group');
            const groupChecked = $(`.permission-checkbox[data-group=${groupId}]:checked`).length;
            const groupTotal = $(`.permission-checkbox[data-group=${groupId}]`).length;

            $(`#${groupId}`).prop('checked', groupChecked === groupTotal);
            updateMasterCheckbox();
        });

        function updateMasterCheckbox() {
            const totalPermissions = $('.permission-checkbox').length;
            const checkedPermissions = $('.permission-checkbox:checked').length;
            $('#checkAllPermissions').prop('checked', totalPermissions === checkedPermissions);
        }
    });
</script>
@endsection