@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-4 col-md-4 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Job Posted By') {{__(@$job->user->name)}}</h5>

                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $job->user->image, imagePath()['profile']['user']['size']) }}" alt="@lang('Image')" class="b-radius--10 withdraw-detailImage" >
                        </div>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Date')
                            <span class="font-weight-bold">{{ showDateTime($job->created_at) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Job Code')
                            <span class="font-weight-bold">{{ $job->job_code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">
                                <a href="{{ route('admin.users.detail', $job->user->id) }}">{{ @$job->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('User Balance')
                            <span class="font-weight-bold">{{ showAmount($job->user->balance) }}&nbsp;{{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Quantity')
                            <span class="font-weight-bold">{{__($job->quantity)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Amount')
                            <span class="font-weight-bold">{{ showAmount($job->rate ) }} {{ __($general->cur_text) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Amount')
                            <span class="font-weight-bold">{{ showAmount($job->total ) }} {{ __($general->cur_text) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($job->status == 0)
                                <span class="badge badge-pill bg--warning">@lang('Pending')</span>
                            @elseif($job->status == 1)
                                <span class="badge badge-pill bg--primary">@lang('Approved')</span>
                            @elseif($job->status == 2)
                                <span class="badge badge-pill bg--success">@lang('Completed')</span>
                            @elseif($job->status == 3)
                                <span class="badge badge-pill bg--dark">@lang('Paused')</span>
                            @elseif($job->status == 9)
                                <span class="badge badge-pill bg--danger">@lang('Rejected')</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 mb-30">

            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('Job More Information')</h5>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h6>@lang('Job Title')</h6>
                            <p>{{ __($job->title) }}</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h6>@lang('Job Description')</h6>
                            <p> @php echo $job->description; @endphp</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h6>@lang('Job File')</h6>
                            <img src="{{getImage('assets/images/attachment/files/'.$job->attachment)}}" alt="@lang('Image')" class="w-50">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button class="btn btn--success ml-1 approveBtn" data-toggle="tooltip" data-original-title="@lang('Approve')"
                                    data-id="{{ $job->id }}" data-status="1" data-user_id={{ $job->user_id }}>
                                <i class="fas la-check"></i> @lang('Approve')
                            </button>

                            <button class="btn btn--danger ml-1 rejectBtn" data-toggle="tooltip" data-original-title="@lang('Reject')"
                            data-id="{{ $job->id }}" data-status="9" data-user_id={{ $job->user_id }}>
                                <i class="fas fa-ban"></i> @lang('Reject')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="rejectModal" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-times-circle f-size--100 text--danger mb-15"></i>
                    <h3 class="text--danger mb-15">@lang('Error: Are you sure!')</h3>
                    <form action="{{ route('admin.jobs.request') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="status" value="">
                        <input type="hidden" name="user_id" value="">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"
                            aria-label="Close">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--danger">@lang('Continue')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="approveModal" class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">
                    <i class="las la-check-circle f-size--100 text--success mb-15"></i>
                    <h3 class="text--success mb-15">@lang('Are you sure!')</h3>
                    <form action="{{ route('admin.jobs.request') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="status" value="">
                        <input type="hidden" name="user_id" value="">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"
                            aria-label="Close">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--success">@lang('Continue')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
                modal.find('input[name=user_id]').val($(this).data('user_id'));
                modal.modal('show');
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=status]').val($(this).data('status'));
                modal.find('input[name=user_id]').val($(this).data('user_id'));
                modal.modal('show');
            });
        })(jQuery);

    </script>
@endpush
