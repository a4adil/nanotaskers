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
                                    <th>@lang('Show home')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(imagePath()['category']['path'] . '/' . $category->image, imagePath()['category']['size']) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span class="name">{{ __($category->name) }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($category->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">
                                                    @lang('Enable')
                                                </span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">
                                                    @lang('Disabled')
                                                </span>
                                            @endif

                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($category->featured == 1)
                                                <span class="text--small badge font-weight-normal badge--primary">
                                                    @lang('Yes')
                                                </span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">
                                                    @lang('No')
                                                </span>
                                            @endif

                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button data-toggle="modal" data-target="#editCategory" class="icon-btn bg--primary ml-1 editButton"
                                            data-id="{{ $category->id }}" data-name="{{ __($category->name) }}"
                                            data-status="{{ __($category->status) }}"
                                            data-featured="{{ __($category->featured) }}"
                                            data-short_description="{{ __($category->short_description) }}"
                                            data-image="{{ __($category->image) }}"
                                            data-original-title="@lang('Edit')">
                                                <i class="las la-pen"></i>
                                            </button>
                                            @if ($category->status == 1)
                                                <button class="icon-btn bg--danger deleteButton" data-toggle="modal"
                                                    data-id="{{ $category->id }}"
                                                    data-status="{{ __($category->status) }}"
                                                    data-target="#deleteCategory" data-original-title="@lang('Delete')">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            @else
                                                <button class="icon-btn bg--success restoreButton" data-toggle="modal"
                                                    data-id="{{ $category->id }}"
                                                    data-status="{{ __($category->status) }}"
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
                    {{ paginateLinks($categories) }}
                </div>
            </div>
        </div>
    </div>
    <div id="createCategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Add New Category')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Short description') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Image') <span
                                    class="text-danger">*</span></label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                            style="background-image: url({{ getImage('/', imagePath()['category']['size']) }})">
                                            <button type="button" class="remove-image">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                            accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--primary">@lang('Upload
                                            Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'):
                                            <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into
                                            64x64') </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Show home')
                            </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="featured">
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
                        @lang('Update Category')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.update') }}" method="POST" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Short description') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Image') <span
                                    class="text-danger">*</span></label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                            style="background-image: url({{ getImage('/', imagePath()['category']['size']) }})">
                                            <button type="button" class="remove-image">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2"
                                            accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="bg--primary">@lang('Upload
                                            Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'):
                                            <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into
                                            70x70') </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Status')</label>
                            <input type="checkbox" id="status" data-width="100%" data-onstyle="-success"
                                data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                data-off="@lang('Disabled')" name="status">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Show home')
                            </label>
                            <input type="checkbox" id="featured" data-width="100%" data-onstyle="-success"
                                data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                name="featured">
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
                    <form action="{{ route('admin.category.delete') }}" method="POST">
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
                    <form action="{{ route('admin.category.delete') }}" method="POST">
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
    @if (request()->routeIs('admin.category.index'))
        <a href="{{ route('admin.category.trash') }}" class="btn btn-sm btn--danger mr-2"><i class="las la-trash-restore"></i>
            @lang('Trashed')
        </a>
        <a data-toggle="modal" href="#createCategory" class="btn btn-sm btn--primary mr-2"><i class="las la-plus"></i>
            @lang('Add new')
        </a>
    @else
        <a href="{{ route('admin.category.index') }}" class="btn btn-sm btn--success mr-2"><i class="las la-check"></i>
            @lang('Active')
        </a>
    @endif

    <form method="GET" class="form-inline float-sm-right search-form w-sm-auto w-unset">
        <div class="input-group has_append">
            <input type="text" name="search" id="mySearch" class="form-control  bg-white" placeholder="@lang('Category name')"
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
