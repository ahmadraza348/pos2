@extends('backend.layouts.layout')
@section('title', 'Edit Permissions - Raza Mall')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h6>Edit Permissions for Role: <span class="text-primary">{{ $role->name }}</span></h6>
            </div>
        </div>

      <form method="post" action="{{ route('admin.roles_permissions.update', ['role_permission' => $role->id]) }}">
    @csrf
    @method('PUT')

            <div class="card">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label class="form-label font-weight-bold" for="role">Role</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                </select>
                                @error('role')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="col-lg-12">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="checkAllPermissions">
                                <label class="form-check-label" for="checkAllPermissions"><strong>Select All Permissions</strong></label>
                            </div>

                            @foreach ($permission_groups as $group)
                            <div class="row mb-4 border-bottom pb-2">
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        {{-- Group Checkbox --}}
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
                                                    data-group="group-{{ $loop->parent->index }}"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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

                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                            <a href="{{ route('admin.roles_permissions.index') }}" class="btn btn-secondary">Cancel</a>
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

        // --- INITIALIZE ON PAGE LOAD ---
        // Checks if groups or "Select All" should be checked based on existing permissions
        initCheckboxes();

        function initCheckboxes() {
            $('.group-checkbox').each(function() {
                const groupId = $(this).attr('id');
                const total = $(`.permission-checkbox[data-group=${groupId}]`).length;
                const checked = $(`.permission-checkbox[data-group=${groupId}]:checked`).length;
                if (total > 0 && total === checked) {
                    $(this).prop('checked', true);
                }
            });
            updateMasterCheckbox();
        }

        // --- EVENT HANDLERS ---

        // 1. Master Checkbox
        $('#checkAllPermissions').click(function() {
            $('input[type=checkbox]').prop('checked', $(this).is(':checked'));
        });

        // 2. Group Checkbox
        $('.group-checkbox').click(function() {
            const groupId = $(this).attr('id');
            $(`input[data-group=${groupId}]`).prop('checked', $(this).is(':checked'));
            updateMasterCheckbox();
        });

        // 3. Individual Checkbox
        $('.permission-checkbox').click(function() {
            const groupId = $(this).data('group');
            const total = $(`.permission-checkbox[data-group=${groupId}]`).length;
            const checked = $(`.permission-checkbox[data-group=${groupId}]:checked`).length;

            $(`#${groupId}`).prop('checked', total === checked);
            updateMasterCheckbox();
        });

        function updateMasterCheckbox() {
            const totalPerms = $('.permission-checkbox').length;
            const checkedPerms = $('.permission-checkbox:checked').length;
            $('#checkAllPermissions').prop('checked', totalPerms === checkedPerms && totalPerms > 0);
        }
    });
</script>
@endsection