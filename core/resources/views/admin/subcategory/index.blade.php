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
                                    <th> @lang('Name')</th>
                                    <th> @lang('Minimum Price')</th>
                                    <th> @lang('Speed')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subcategories as $subcategory)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(imagePath()['subcategory']['path'] . '/' . $subcategory->image, imagePath()['subcategory']['size']) }}"
                                                        alt="@lang('image')">
                                                </div>
                                                <span class="name">{{ __($subcategory->name) }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Minimum Price')">
                                            <div class="thumb">
                                                <span
                                                    class="name">{{ __($subcategory->min_price ?? '') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Minimum Price')">
                                            <div class="thumb">
                                                <span
                                                    class="name">{{ __($subcategory->speed ?? '') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Minimum Price')">
                                            <div class="thumb">
                                                <span
                                                    class="name">{{ __($subcategory->category->name ?? '') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($subcategory->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">
                                                    @lang('Enabled')
                                                </span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">
                                                    @lang('Disabled')
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn editButton ml-1"
                                            data-id="{{ $subcategory->id }}"
                                            data-name="{{ __($subcategory->name) }}"
                                            data-min_price="{{ __($subcategory->min_price) }}"
                                            data-speed="{{ __($subcategory->speed) }}"
                                            data-status="{{ __($subcategory->status) }}"
                                            data-featured="{{ __($subcategory->featured) }}"
                                            data-category="{{ $subcategory->category_id }}"
                                            data-short_description="{{ $subcategory->short_description }}"
                                            data-image="{{ $subcategory->image }}"
                                            data-toggle="modal" data-target="#editSubcategory" data-toggle="tooltip" title="" data-original-title="Detail">
                                                <i class="las la-pen"></i>
                                            </button>
                                            @if ($subcategory->status == 1)
                                                <button href="" class="icon-btn btn--danger deleteButton" data-toggle="modal"
                                                    data-id="{{ $subcategory->id }}"
                                                    data-status="{{ $subcategory->status }}"
                                                    data-target="#deleteSubcategory" data-original-title="@lang('Delete')">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            @else
                                                <button href="" class="icon-btn btn--success restoreButton" data-toggle="modal"
                                                    data-id="{{ $subcategory->id }}"
                                                    data-status="{{ $subcategory->status }}"
                                                    data-target="#restoreSubcategory"
                                                    data-original-title="@lang('restore')">
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
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($subcategories) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    <div id="createSubcategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Add New Subcategory')
                    </h5>
                </div>
                <form action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Category Name') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <select name="category_id" class="form-control">
                                    <option value="" selected disabled>@lang('Select one')</option>
                                    @foreach ($allCategory as $category)
                                        <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected="selected" @endif>{{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                                @lang('Minimum Price') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="min_price" class="form-control" value="{{ old('min_price') }}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Speed') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="speed" class="form-control" value="{{ old('speed') }}" />
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
                                            style="background-image: url({{ getImage('/', imagePath()['subcategory']['size']) }})">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editSubcategory" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Update Subcategory')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.subcategory.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Category Name') <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" name="id" value="" />
                            <div class="input-group">
                                <select name="category_id" id="edit_category_id" class="form-control">
                                    <option value="" selected disabled>@lang('Select one')</option>
                                    @foreach ($allCategory as $category)
                                        <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Name')
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Minimum Price')
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="min_price" class="form-control" value="" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Speed')
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="speed" class="form-control" value="" />
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
                                            style="background-image: url({{ getImage('/', imagePath()['subcategory']['size']) }})">
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
                                data-off=" @lang('Disabled')"
                                name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="deleteSubcategory" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-times-circle f-size--100 text--danger mb-15"></i>
                    <h3 class="text--danger mb-15">@lang('Error: Are you sure!')</h3>
                    <form action="{{ route('admin.subcategory.delete') }}" method="POST">
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
    <div id="restoreSubcategory" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-check-circle f-size--100 text--success mb-15"></i>
                    <h3 class="text--success mb-15">@lang('Are you sure!')</h3>
                    <form action="{{ route('admin.subcategory.delete') }}" method="POST">
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
    @if (request()->routeIs('admin.subcategory.index'))
    <a href="{{ route('admin.subcategory.trash') }}"
        class="btn btn-sm btn--danger mr-2"><i class="las la-trash-restore"></i>
        @lang('Trashed')
    </a>
    <a data-toggle="modal" href="#createSubcategory"
        class="btn btn-sm btn--primary mr-2"><i class="las la-plus"></i> @lang('Add new')
    </a>
    @else
    <a href="{{ route('admin.subcategory.index') }}"
        class="btn btn-sm btn--success mr-2"><i class="las la-check"></i>
        @lang('Active')
    </a>
    @endif

    <form method="GET" class="form-inline float-sm-right bg--white search-form">
        <div class="input-group has_append">
            <input type="text" name="search" id="mySearch" class="form-control" placeholder="@lang('Subcategory name')"
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
                var modal = $('#editSubcategory');
                var featured = $(this).data('featured');
                var status = $(this).data('status');
                var status = $(this).data('status');
                var shortDescription = $(this).data('short_description');
                var category_id = $(this).data('category');
                var min_price = $(this).data('min_price');
                var speed = $(this).data('speed');
                var category = $(`#edit_category_id option[value=${category_id}]`).attr('selected', 'selected')

                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=min_price]').val($(this).data('min_price'));
                modal.find('input[name=speed]').val($(this).data('speed'));
                modal.find('textarea').val(shortDescription);

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
                var x = $(this).data('image');
                $(".profilePicPreview").css("background-image",
                    `url({{ asset('assets/images/subcategory/${x}') }})`);
            });
            $('.deleteButton').on('click', function() {
                var modal = $('#deleteSubcategory');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
            });
            $('.restoreButton').on('click', function() {
                var modal = $('#restoreSubcategory');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
            });

        })(jQuery);
    </script>

@endpush
