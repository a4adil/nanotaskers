@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row gy-5">
    <div class="col-lg-7 col-xl-8 col-md-12">
        <div class="announcement__details">
            <h3 class="blog-title">{{ __($proof->job->title) }}</h3>
                <ul class="announcement__meta d-flex flex-wrap mt-2 mb-3 align-items-center">
                    <li><a href="#"><i class="far fa-calendar"></i>{{ showDateTime($proof->job->created_at) }}</a></li>
                </ul>
            <div class="announcement__details__content">
                <h6 class="mb-2">@lang('Detail : ')</h6>
                <p>{{ $proof->detail }}</p>
            </div>
            @if ($proof->attachment != null)     
            <div class="announcement__details__content">
                <h6 class="my-2">@lang('Attachment : ')</h6>
                <a href="{{ route('user.attachment.download', $proof->id) }}" class="mr-3 text--base"><i class="las la-file"></i>
                    @lang('Attachment')
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 sidebar-right theiaStickySidebar">
        <div class="widget-box post-widget attachment-widget">
            <h4 class="pro-title">@lang('Job Request')</h4>
            <ul class="latest-posts m-0">
                <li class="flex-wrap">
                    <div class="post-thumb">
                            <img class="img-fluid" src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $proof->user->image, imagePath()['profile']['user']['size']) }}" alt="@lang('image')">
                    </div>
                    <div class="post-info attachment-info">
                        <h6>{{ $proof->user->username }}</h6>
                        <p>@lang('Rate : '){{ $general->cur_sym }}{{ showAmount($proof->job->rate )}}</p>
                    </div>
                </li>
                <li>
                    <div class="d-flex flex-wrap w-100" style="gap:7px">
                        @if ($proof->status == 0)                            
                        <a href="javascript:void(0)" data-id="{{ $proof->id }}" data-rate="{{ $proof->job->rate }}" 
                            class="btn btn--base btn--sm approve no" data-bs-toggle="modal"
                            data-bs-target="#approveModal"><i class="las la-check"></i>&nbsp;@lang('Approve')
                        </a>
                        <a href="javascript:void(0)" data-id="{{ $proof->id }}" data-rate="{{ $proof->job->rate }}" 
                            class="btn btn--danger btn--sm reject" data-bs-toggle="modal"
                            data-bs-target="#rejectModal"><i class="las la-times"></i>&nbsp;@lang('Reject')
                        </a>
                        @elseif($proof->status == 1)
                            <span class="badge badge--success">@lang('Approved')</span>
                        @else
                            <span class="badge badge--danger">@lang('Rejected')</span>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

    <div class="modal modal-danger fade" id="approveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text--base">@lang('Approve Job Request')</h4>
                </div>
                <form action="{{ route('user.job.approve') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="proof_id" type="hidden" name="id" required value="{{ old('id') }}" readonly>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form--control radius-5 border border--dark" name="amount"
                                    placeholder="@lang('Amount')" required value="{{ old('amount') }}" readonly>
                                <span class="input-group-text" id="basic-addon2">{{ $general->cur_text }}</span>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn-dark" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--md btn--base">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('user.job.reject') }}" method="post">
                    @csrf
                    <div class="modal-body text-center">
                        <i class="las la-times-circle fs-1 text--danger"></i>
                        <h3 class="text--danger mb-3">@lang('Are you sure!')</h3>
                        <input type="hidden" name="id" required value="{{ old('id') }}" readonly>
                        <button type="button" class="btn btn--md btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--md btn--base">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        @media (max-width:1199px) {
            @media(min-width:992px) {
                .approve, .reject {
                    width: 100%
                }
            }
        }
    </style>
@endpush
@push('script')
<script>
    (function($) {
        "use strict";
        $('.approve').on('click', function() {
            var id = $(this).data('id');
            var rate = $(this).data('rate');
            $('#amount').val(parseFloat(rate).toFixed(2));
            $('#proof_id').val(id);
        });
        $('.reject').on('click', function() {
            var modal = $("#rejectModal");
            modal.find('input[name=id]').val($(this).data('id'));
        });
    })(jQuery);
</script>
@endpush
