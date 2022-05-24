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
                                    <th>@lang('Job ID')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Rate')</th>
                                    <th>@lang('Total')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td data-label="@lang('Job ID')">
                                            <div class="user">
                                                <span class="name">{{ __($job->job_code) }}</span>
                                                <span class="name font-weight-bold">
                                                    <a href="{{ route('admin.users.detail', $job->user->id) }}">{{ __($job->user->fullname) }}</a>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Quantity')">
                                            <span class="font-weight-bold">{{ $job->quantity }}</span>
                                        </td>
                                        <td data-label="@lang('Rate')">
                                            <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($job->rate) }}</span>
                                        </td>
                                        <td data-label="@lang('Balance')">
                                            <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($job->total) }}</span>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($job->status == 0)
                                                <span class="text--small badge font-weight-normal badge--warning">
                                                    @lang('Pending')
                                                </span>
                                            @elseif ($job->status == 1)
                                                <span class="text--small badge font-weight-normal badge--primary">
                                                    @lang('Approved')
                                                </span>

                                            @elseif ($job->status == 2)
                                                <span class="text--small badge font-weight-normal badge--success">
                                                    @lang('Completed')
                                                </span>
                                            @elseif ($job->status == 3)
                                                <span class="text--small badge font-weight-normal badge--dark">
                                                    @lang('Paused')
                                                </span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--danger">
                                                    @lang('Rejected')
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Created At')">
                                            {{ showDateTime($job->created_at) }} <br> {{ diffForHumans($job->created_at) }}
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.jobs.detail',$job->id) }}" class="icon-btn edit mr-1" data-toggle="tooltip" title="" data-original-title="Detail">
                                                <i class="las la-desktop"></i>
                                            </a>
                                            <a href="{{ route('admin.jobs.view',$job->id) }}" class="icon-btn btn--dark" data-toggle="tooltip" title="" data-original-title="View">
                                                <i class="las la-eye"></i>
                                            </a>
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
                    {{ paginateLinks($jobs) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Approve Job Status')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.jobs.request') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">
                                @lang('Job Status') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <select name="status" id="" class="form-control">
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    <option value="1">@lang('Approve')</option>
                                    <option value="9">@lang('Reject')</option>
                                </select>
                            </div>
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
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Job Details')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="job-title"></h6>
                    <p class="job-description mt-2"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancel')</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white search-form">
        <div class="input-group has_append">
            <input type="text" name="search" id="mySearch" class="form-control" placeholder="@lang('Job ID')"
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
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
            });
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                modal.find('.job-title').text($(this).data('title'));
                var description = $(this).data('description');
                modal.find('.job-description').html(description);
            });
        })(jQuery);
    </script>
@endpush
