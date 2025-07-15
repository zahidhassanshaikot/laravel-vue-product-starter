@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="ic-role">
                <form action="{{ route('roles.update', $role->id) }}" method="POST" id="form">
                    @csrf
                    @method('PUT')

                    <!-- Role Name -->
                    <div class="ic_form row mb_24">
                        <div class="col-lg-8">
                            <label class="form-label">{{ __('Role Name') }}</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $role->name) }}" placeholder="{{ __('Enter role name') }}">
                        </div>
                    </div>

                    <!-- Check All Permissions -->
                    <div class="ic_form mb_24">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" id="customCheck-all" class="form-check-input"
                                >
                            <label class="form-check-label mb-0" for="customCheck-all">
                                {{ __('Check All Permissions') }}
                            </label>
                        </div>
                    </div>

                    <!-- Permissions Accordion -->
                    <div class="ic_form gx-xxl-4 gx-xl-3 gx-sm-2 row">
                        @foreach ($permissions as $permission)
                            @if ($permission->parent_id === null)
                                <div class="col-md-4 col-sm-6 mb_24">
                                    <div class="accordion" id="accordionPermission_{{ $permission->id }}">
                                        <div class="accordion-item" data-id="{{ $permission->id }}">
                                            <h2 class="accordion-header" id="role_{{ $permission->id }}">
                                                <div class="ic-check-all d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="permissions[]"
                                                        class="form-check-input parent-check"
                                                        id="customCheck-{{ $permission->id }}"
                                                        onchange="loadChildren({{ $permission->id }})"
                                                        value="{{ $permission->name }}"
                                                        {{ in_array($permission->id, $role_permission) ? 'checked' : '' }}>
                                                    <label class="form-check-label mb-0"
                                                        for="customCheck-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseRole_{{ $permission->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseRole_{{ $permission->id }}">
                                                </button>
                                            </h2>
                                            <div id="collapseRole_{{ $permission->id }}"
                                                class="accordion-collapse collapse"
                                                aria-labelledby="role_{{ $permission->id }}"
                                                data-bs-parent="#accordionPermission_{{ $permission->id }}">
                                                <div class="accordion-body">
                                                    @foreach ($permission->childs as $children)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input child-check parent-identy-{{ $permission->id }}"
                                                                name="permissions[]" id="customCheck-{{ $children->id }}"
                                                                value="{{ $children->name }}"
                                                                {{ in_array($children->id, $role_permission) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="customCheck-{{ $children->id }}">
                                                                {{ $children->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <div class="right-button-group">
                            <a href="{{ route('roles.index') }}" class="ic-button white">{{ __('Cancel') }}</a>
                            <button type="submit" class="ic-button primary">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            // Check/Uncheck all
            $('#customCheck-all').on('change', function () {
                const isChecked = $(this).is(':checked');
                $('input[type="checkbox"][name="permissions[]"]').prop('checked', isChecked);
            });

            // Auto-update 'Check All' if all individual checkboxes are checked manually
            $(document).on('change', 'input[type="checkbox"][name="permissions[]"]', function () {
                const total = $('input[type="checkbox"][name="permissions[]"]').length;
                const checked = $('input[type="checkbox"][name="permissions[]"]:checked').length;
                $('#customCheck-all').prop('checked', total === checked);
            });
        });

        // Toggle child permissions on parent toggle
        function loadChildren(parent_id) {
            const isChecked = $(`#customCheck-${parent_id}`).is(':checked');
            $(`.parent-identy-${parent_id}`).prop('checked', isChecked);

            // Re-check if all permissions are selected
            const total = $('input[type="checkbox"][name="permissions[]"]').length;
            const checked = $('input[type="checkbox"][name="permissions[]"]:checked').length;
            $('#customCheck-all').prop('checked', total === checked);
        }
    </script>
@endpush

@push('style')
@endpush
