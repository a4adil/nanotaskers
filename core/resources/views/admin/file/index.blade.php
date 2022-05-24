@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($files as $file)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <div class="user">
                                                <span class="name">{{ __($file->name) }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($file->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">
                                                    @lang('Enable')
                                                </span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">
                                                    @lang('Disabled')
                                                </span>
                                            @endif

                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn editButton ml-1" data-toggle="modal"
                                                data-id="{{ $file->id }}" data-name="{{ __($file->name) }}"
                                                data-status="{{ __($file->status) }}" data-target="#editCategory"
                                                data-original-title="@lang('Edit')">
                                                <i class="la la-pencil"></i>
                                            </button>
                                            @if ($file->status == 1)
                                                <button class="icon-btn bg--danger deleteButton" data-toggle="modal"
                                                    data-id="{{ $file->id }}"
                                                    data-status="{{ __($file->status) }}"
                                                    data-target="#deleteCategory" data-original-title="@lang('Delete')">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            @else
                                                <button class="icon-btn bg--success restoreButton" data-toggle="modal"
                                                    data-id="{{ $file->id }}"
                                                    data-status="{{ __($file->status) }}"
                                                    data-target="#restoreCategory" data-original-title="@lang('restore')">
                                                    <i class="las la-reply"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($files) }}
                </div>
            </div>
        </div>
    </div>
    <div id="createCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Add New File')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.files.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Name') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Update Files')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.files.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" />
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Name') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control border-radius-5" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">
                            @lang('Cancel')</button>
                        <button type="submit" class="btn btn--primary">
                            @lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteCategory" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-times-circle f-size--100 text--danger mb-15"></i>
                    <h3 class="text--danger mb-15">@lang('Error: Are you sure!')</h3>
                    <form action="{{ route('admin.files.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="status" value="">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"
                            aria-label="Close">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--danger">@lang('Continue')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="restoreCategory" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-check-circle f-size--100 text--success mb-15"></i>
                    <h3 class="text--success mb-15">@lang('Are you sure!')</h3>
                    <form action="{{ route('admin.files.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="status" value="">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"
                            aria-label="Close">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--success">@lang('Continue')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if (request()->routeIs('admin.files.index'))
        <a href="{{ route('admin.files.trash') }}"
            class="btn btn-sm btn--danger mr-2"><i class="las la-trash-restore"></i>
            @lang('Trashed')</a>
        <a data-toggle="modal" href="#createCategory"
            class="btn btn-sm btn--primary mr-2"><i class="las la-plus"></i>
            @lang('Add new')</a>
    @else
        <a href="{{ route('admin.files.index') }}"
        class="btn btn-sm btn--success mr-2"><i class="las la-check"></i>
        @lang('Active')</a>
    @endif
    <form method="GET" class="form-inline float-sm-right search-form w-sm-auto w-unset">
        <div class="input-group has_append">
            <input type="text" name="search" id="mySearch" class="form-control  bg-white" placeholder="@lang('File name')"
                value="{{ request()->search }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

@endpush
@push('script')
    <script>
        (function($) {
            "use strict"
            $('.editButton').on('click', function() {
                var modal = $('#editCategory');
                var featured = $(this).data('featured');
                var status = $(this).data('status');
                var shortDescription = $(this).data('short_description');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('textarea').val(shortDescription);

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                if ($(this).data('featured') == 1) {
                    modal.find('input[name=featured]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=featured]').bootstrapToggle('off');
                }
                var x = $(this).data('image');
                $(".profilePicPreview").css("background-image",
                    `url({{ asset('assets/images/category/${x}') }})`);

            });
            $('.deleteButton').on('click', function() {
                var modal = $('#deleteCategory');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
            });
            $('.restoreButton').on('click', function() {
                var modal = $('#restoreCategory');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
            });
        })(jQuery);
    </script>
@endpush
