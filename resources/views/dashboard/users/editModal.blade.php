<!-- Edit Modal -->
<div class="modal fade custom-modal" id="editModal{{$item->id}}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header flex-wrap">
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.User') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('user.update', 'test') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- first_name -->
                    <div class="form-group">
                        <label>{{ trans('main.First Name') }}</label>
                        <input class="form-control" type="text" class="form-control" name="first_name" value="{{ $item->first_name }}" required>
                    </div>
                    <!-- last_name -->
                    <div class="form-group">
                        <label>{{ trans('main.Last Name') }}</label>
                        <input class="form-control" type="text" class="form-control" name="last_name" value="{{ $item->last_name }}" required>
                    </div>
                    <!-- email -->
                    <div class="form-group">
                        <label>{{ trans('main.Email') }}</label>
                        <input class="email form-control" type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                    </div>
                    <!-- mobile -->
                    <div class="form-group">
                        <label>{{ trans('main.Mobile') }}</label>
                        <input class="mobile form-control" type="text" class="form-control" name="mobile" value="{{ $item->mobile }}" required>
                    </div>
                    <!-- status -->
                    <div class="form-group">
                        <label>{{ trans('main.Status') }}</label>
                        <select class="status form-control form-select" name="status" required>
                            <option value="1" {{ $item->status == 1 ? 'selected' : ''}}>{{ trans('main.Active') }}</option>
                            <option value="0" {{ $item->status == 0 ? 'selected' : ''}}>{{ trans('main.InActive') }}</option>
                        </select>
                    </div>
                    <!-- roles -->
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.Role') }} :</label>
                        <select class="form-control form-select" name="roles" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $item->roles[0]->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        {{-- {!! Form::select('roles[]', $roles,$item->roles->pluck('name','name')->all(), array('class' => 'form-control')) !!} --}}
                    </div>
                    @if(request()->is('admin/employee'))
                    <!-- employee_div_edit -->
                    <div class="employee_div_edit">
                        <!-- salary -->
                        <div class="form-group">
                            <label>{{ trans('main.Salary') }}</label>
                            <input class="form-control" type="text" class="form-control" name="salary" value="{{ $item->salary,old('salary') }}">
                        </div>
                        <!-- department_id -->
                        <div class="form-group">
                            <label class="form-label">{{ trans('main.Department') }} :</label>
                            <select class="form-control form-select" name="department_id" required>
                                <option value="">{{ trans('main.Choose') }}</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $item->department_id == $department->id ? 'selected' : ''}}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <!-- photo -->
                    <div class="form-group">
                        <label>{{ trans('main.Photo') }}</label>
                        <input class="form-control" type="file" class="form-control" name="photo" value="{{ @$item->photo }}">
                        @if($item->media)
                        <div class="row">
                            <div class="col-12">
                                <img id="preview_image" class="img-thumbnail m-1" src="{{ asset('attachments/user/'.$item->media->file_name) }}" height="70" width="70">
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- id -->
                    <div class="col-6">
                        <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->