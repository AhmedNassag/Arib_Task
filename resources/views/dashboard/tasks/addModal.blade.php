<!-- Start Modal -->
<div class="modal fade custom-modal" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Add') }} {{ trans('main.Task') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('task.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <!-- name -->
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input type="text" class="form-control name" name="name" value="{{ old('name') }}" placeholder="{{ trans('main.Name') }}">
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <label>{{ trans('main.Description') }}</label>
                        <textarea type="text" class="form-control description" name="description" value="{{ old('description') }}" placeholder="{{ trans('main.Description') }}">{{ old('description') }}</textarea>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>
                    <!-- employee_id -->
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.Employee') }} :</label>
                        <select class="form-control form-select" name="employee_id">
                            <option value="">{{ trans('main.Choose') }}</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $employee->id == old('employee_id') ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- created_by -->
                    <div class="form-group">
                        <input type="hidden" class="form-control created_by" name="created_by" value="{{ auth()->user()->id }}" placeholder="{{ trans('main.CreatedBy') }}">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->