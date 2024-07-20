<!-- Start Modal -->
<div class="modal fade custom-modal" id="editModal{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.Department') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('task.update', 'test') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ method_field('PUT') }}
                    @csrf
                    <!-- name -->
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input class="form-control" type="text" name="name" placeholder="{{ trans('main.Name') }}"  value="{{ $item->name }}" required>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <label>{{ trans('main.Description') }}</label>
                        <textarea type="text" class="form-control description" name="description" placeholder="{{ trans('main.Description') }}">{{ $item->description }}</textarea>
                        <div class="valid-feedback">{{ trans('main.Looks Good') }}</div>
                        <div class="invalid-feedback">{{ trans('main.Error Here')}}</div>
                    </div>
                    <!-- employee_id -->
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.employee') }} :</label>
                        <select class="form-control form-select" name="employee_id" required>
                            <option value="">{{ trans('main.Choose') }}</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $employee->id == $item->employee->id ? 'selected' : ''}}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- id -->
                    <div class="form-group">
                        <input class="form-control" type="hidden" name="id" value="{{ $item->id }}">
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
