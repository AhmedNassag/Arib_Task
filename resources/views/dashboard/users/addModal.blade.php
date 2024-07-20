<!-- Add Modal -->
<div class="modal fade custom-modal" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header flex-wrap">
                <h4 class="modal-title">{{ trans('main.Add') }} {{ trans('main.User') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <ul id="error_list"></ul>
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- first_name -->
                    <div class="form-group">
                        <label>{{ trans('main.First Name') }}</label>
                        <input class="form-control" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                    </div>
                    <!-- last_name -->
                    <div class="form-group">
                        <label>{{ trans('main.Last Name') }}</label>
                        <input class="form-control" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                    </div>
                    <!-- email -->
                    <div class="form-group">
                        <label>{{ trans('main.Email') }}</label>
                        <input class="email form-control" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>
                    <!-- mobile -->
                    <div class="form-group">
                        <label>{{ trans('main.Mobile') }}</label>
                        <input class="mobile form-control" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                    </div>
                    <!-- password -->
                    <div class="form-group">
                        <label>{{ trans('main.Password') }}</label>
                        <input class="password form-control" type="password" class="form-control" name="password" required>
                    </div>
                    <!-- confirm-password -->
                    <div class="form-group">
                        <label>{{ trans('main.Confirm') }} {{ trans('main.Password') }}</label>
                        <input class="confirm-password form-control" type="password" class="form-control" name="confirm-password" required>
                    </div>
                    <!-- status -->
                    <div class="form-group">
                        <label>{{ trans('main.Status') }}</label>
                        <select class="status form-control form-select" name="status" required>
                            <option value="1">{{ trans('main.Active') }}</option>
                            <option value="0">{{ trans('main.InActive') }}</option>
                        </select>
                    </div>
                    <!-- roles_name -->
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.Role') }} :</label>
                        <select class="form-control form-select" name="roles_name" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('roles_name') == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        {{-- {!! Form::select('roles_name', $roles,[], array('class' => 'form-control')) !!} --}}
                    </div>
                    <!-- employee_div -->
                    @if(request()->is('admin/employee'))
                    <div id="employee_div">
                        <!-- salary -->
                        <div class="form-group">
                            <label>{{ trans('main.Salary') }}</label>
                            <input class="form-control" type="text" class="form-control" name="salary" value="{{ 0,old('salary') }}">
                        </div>
                        <!-- department_id -->
                        <div class="form-group">
                            <label class="form-label">{{ trans('main.Department') }} :</label>
                            <select class="form-control form-select" name="department_id">
                                <option value="">{{ trans('main.Choose') }}</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <!-- photo -->
                    <div class="form-group">
                        <label>{{ trans('main.Photo') }}</label>
                        <input class="form-control" type="file" class="form-control" name="photo" value="{{ old('photo') }}">
                    </div>
                    <div class="mt-4">
                        <button id="storeBtn" type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </from>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->