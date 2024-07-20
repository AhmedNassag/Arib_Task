<?php $page="role";?>

@extends('layouts.master')



@section('content')

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">{{ trans('main.Roles') }}</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
									
									<li class="breadcrumb-item active">{{ trans('main.Roles') }}</li>
								</ul>
							</div>
							<div class="col-auto">
                                @can('إضافة الصلاحيات')
                                <a type="button" class="btn add-button me-2" href="{{ route('role.create') }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                                @endcan
                                <button type="button" class="btn filter-btn me-2" id="filter_search">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <!-- <button type="button" class="btn" id="btn_delete_selected" title="{{ trans('main.Delete Selected') }}" style="display:none; width: 42px; height: 42px; justify-content: center; align-items: center; color: #fff; background: red; border: 1px solid red; border-radius: 5px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button> -->
							</div>
						</div>
					</div>
					<!-- /Page Header -->

                    <!-- Search Filter -->
					<div class="card filter-card" id="filter_inputs" @if($name) style="display:block" @endif>
						<div class="card-body pb-0">
							<form action="{{ route('role.index') }}" method="get">
								<div class="row filter-row">
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.Name') }}</label>
											<input class="form-control" type="text" name="name" value="{{ $name }}">
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<button class="btn btn-primary btn-block" type="submit">{{ trans('main.Search') }}</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- /Search Filter -->


                    <!-- Alert Notify -->
                    <!-- validationNotify -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- success Notify -->
                    @if (session()->has('success'))
                    <script id="successNotify">
                        window.onload = function() {
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    </script>
                    @endif

                    <!-- error Notify -->
                    @if (session()->has('error'))
                    <script id="errorNotify">
                        window.onload = function() {
                            notif({
                                msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                type: "error"
                            })
                        }
                    </script>
                    @endif

                    <!-- canNotDeleted Notify -->
                    @if (session()->has('canNotDeleted'))
                    <script id="canNotDeleted">
                        window.onload = function() {
                            notif({
                                msg: "لا يمكن الحذف لوجود بيانات أخرى مرتبطة بها..!",
                                type: "error"
                            })
                        }
                    </script>
                    @endif
                    <!-- /Alert Notify -->


                    <!-- row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-center table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{ trans('main.Name') }}</th>
                                                    <th class="text-center">{{ trans('main.Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($data->count() > 0)
                                                <?php $i = 0; ?>
                                                @foreach ($data as $key => $role)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td class="text-center">{{ $i }}</td>
                                                        <td class="text-center">{{ $role->name }}</td>
                                                        <td class="text-center">
                                                            @can('عرض الصلاحيات')
                                                                <a type="button" class="btn btn-sm btn-info me-2" href="{{ route('role.show', $role->id) }}" title="{{ trans('main.Show') }}"><i class="fas fa-user-shield"></i></a>
                                                            @endcan
                                                            @if ($role->id !== 1 && $role->id !== 2 && $role->id !== 3)
                                                                @can('تعديل الصلاحيات')
                                                                    <a type="button" class="btn btn-sm btn-secondary" href="{{ route('role.edit', $role->id) }}" title="{{ trans('main.Edit') }}"><i class="far fa-edit"></i></a>
                                                                @endcan
                                                                @can('حذف الصلاحيات')
                                                                    <button type="button" class="deleteBtn btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $role->id }}" title="{{ trans('main.Delete') }}" style="color:white !important"><i class="far fa-trash-alt"></i></button>
                                                                @endcan
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @include('dashboard.roles.deleteModal')
                                                @endforeach
                                                @else
                                                    <tr>
                                                        <th class="text-center" colspan="10">
                                                            <div class="col mb-3 d-flex">
                                                                <div class="card flex-fill">
                                                                    <div class="card-body p-3 text-center">
                                                                        <p class="card-text f-12">{{ trans('main.No Data Founded') }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    @endif
                                            </tbody>
                                        </table>
                                        {{ $data->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>
                    <!-- row closed -->
                </div>
                <!-- content container-fluid closed -->	
            </div>
            <!-- /Page Wrapper -->
        </div>
        <!-- /Main Wrapper -->
@endsection



@section('js')

@endsection
