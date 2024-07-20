<?php $page="user";?>

@extends('layouts.master')



@section('content')
            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">{{ trans('main.Users') }}</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
									<li class="breadcrumb-item active">{{ trans('main.Users') }}</li>
								</ul>
							</div>
							<div class="col-auto">
                                @can('إضافة المستخدمين')
                                <button type="button" class="btn add-button me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                @endcan
                                <button type="button" class="btn filter-btn me-2" id="filter_search">
                                    <i class="fas fa-filter"></i>
                                </button>
                                @can('حذف المستخدمين')
                                <button type="button" class="btn" id="btn_delete_selected" title="{{ trans('main.Delete Selected') }}" style="display:none; width: 42px; height: 42px; justify-content: center; align-items: center; color: #fff; background: red; border: 1px solid red; border-radius: 5px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                @endcan
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<!-- Search Filter -->
					<div class="card filter-card" id="filter_inputs" @if($first_name || $last_name || $email || $mobile) style="display:block" @endif>
						<div class="card-body pb-0">
							<form action="{{ route('user.index') }}" method="get">
								<div class="row filter-row">
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.First Name') }}</label>
											<input class="form-control" type="text" name="first_name" value="{{ $first_name }}">
										</div>
									</div>
                                    <div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.Last Name') }}</label>
											<input class="form-control" type="text" name="last_name" value="{{ $last_name }}">
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.Email') }}</label>
											<input type="email" class="form-control" name="email" value="{{ $email }}">										
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{ trans('main.Mobile') }}</label>
											<input type="text" class="form-control" name="mobile" value="{{ $mobile }}">
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

                    <!-- successNotify -->
                    @if (session()->has('success'))
                        <script id="successNotify" style="display: none;">
                            window.onload = function() {
                                notif({
                                    msg: "تمت العملية بنجاح",
                                    type: "success"
                                })
                            }
                        </script>
                    @endif

                    <!-- errorNotify -->
                    @if (session()->has('error'))
                        <script id="errorNotify" style="display: none;">
                            window.onload = function() {
                                notif({
                                    msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                    type: "error"
                                })
                            }
                        </script>
                    @endif
                    <!-- /Alert Notify -->

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
                                                    <th class="text-center">{{ trans('main.Email') }}</th>
                                                    <th class="text-center">{{ trans('main.Mobile') }}</th>
                                                    <th class="text-center">{{ trans('main.Status') }}</th>
                                                    <th class="text-center">{{ trans('main.Role') }}</th>
                                                    <th class="text-center">{{ trans('main.Photo') }}</th>
                                                    <th class="text-center">{{ trans('main.Actions') }}</th>
												</tr>
											</thead>
											<tbody>
                                                @if($data->count() > 0)
                                                <?php $i = 0; ?>
                                                @foreach ($data as $item)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td class="text-center notPrint">{{ $i }}</td>
                                                        <td class="text-center">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->email }}</td>
                                                        <td class="text-center">{{ $item->mobile }}</td>
                                                        <td class="text-center">
                                                            @if(auth()->user()->can('تغيير حالة المستخدمين'))
                                                                <a href="{{ route('user.changeStatus',$item->id) }}">
                                                                    @if ($item->status == 1)
                                                                        <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                            <span class="label text-success text-center">
                                                                                {{ app()->getLocale() == 'ar' ? 'مفعل' : 'Active' }}
                                                                            </span>
                                                                        </div>
                                                                    @else
                                                                        <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                            <span class="label text-danger text-center">
                                                                                {{ app()->getLocale() == 'ar' ? 'غير مفعل' : 'InActive' }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </a>
                                                            @else
                                                                @if ($item->status == 1)
                                                                    <span class="label text-success text-center">
                                                                        {{ app()->getLocale() == 'ar' ? 'مفعل' : 'Active' }}
                                                                    </span>
                                                                @else
                                                                    <span class="label text-danger text-center">
                                                                        {{ app()->getLocale() == 'ar' ? 'غير مفعل' : 'InActive' }}
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (!empty($item->getRoleNames()))
                                                                @foreach ($item->getRoleNames() as $v)
                                                                    <label class="badge badge-primary">{{ $v }}</label>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="text-center notPrint">
                                                            @if($item->media)
                                                                <img class="mb-1" src="{{ asset('attachments/user/'.$item->media->file_name) }}" alt="{{ $item->media->file_name }}" height="50" width="70">
                                                                <br>
                                                                <a class="btn btn-outline-success btn-sm" href="{{ route('show_file',['user',$item->media->file_name]) }}" role="button" target="_blank"><i class="fas fa-eye"></i></a>
                                                                <a class="btn btn-outline-info btn-sm" href="{{ route('download_file',['user',$item->media->file_name]) }}" role="button" target="_blank"><i class="fas fa-download"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($item->id != 1)
                                                                @can('تعديل المستخدمين')
                                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}"><i class="far fa-edit"></i></button>
                                                                @endcan

                                                                @can('حذف المستخدمين')
                                                                    <button type="button" class="deleteBtn btn btn-sm btn-danger" value="{{ $item->id }}"><i class="far fa-trash-alt"></i></button>
                                                                @endcan
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @include('dashboard.users.editModal')
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
                        @include('dashboard.users.addModal')
                        @include('dashboard.users.deleteModal')
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

    <script>
        $(document).ready(function () {

            //delete
            $(document).on('click','.deleteBtn',function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#delete_id').val(id);
                $('#delete_error_list').html("");
                $('#delete_user').modal('show');
            });
            $(document).on('click','.destroyBtn',function(e){
                e.preventDefault();
                $(this).text('Deleting');
                var id = $('#delete_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "/admin/user/destroy/"+id,
                    success:function(response) {
                        if(response.status == false) {
                            $('#delete_error_list').html("");
                            $('#delete_error_list').addClass('alert alert-danger');
                            $("#delete_error_list").append("<li>"+ response.messages +"</li>");
                        } else {
                            $('#delete_error_list').html("");
                            $('#delete_user').modal('hide');
                            $(this).text('Deleting');
                            location.reload();
                        }
                    },
                    error:function(reject){},
                });
            });

        });
    </script>
@endsection
