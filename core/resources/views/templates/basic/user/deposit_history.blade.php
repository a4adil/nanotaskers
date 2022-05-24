@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="dashboard__content contact__form__wrapper">
        <table class="table transection__table">
            <thead>
                <tr>
                    <th>@lang('Transaction ID')</th>
                    <th>@lang('Gateway')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Time')</th>
                    <th>@lang('More')</th>
                </tr>
            </thead>
            <tbody>
                @if (count($logs) > 0)
                    @foreach ($logs as $k => $data)
                        <tr>
                            <td data-label="#@lang('Trx')">
                                <span class="invoice-id">{{ __($data->trx) }}</span>
                            </td>
                            <td data-label="@lang('Gateway')">
                                <span class="gateway">{{ __(@$data->gateway->name) }} </span>
                            </td>
                            <td data-label="@lang('Amount')">
                                <span class="amount">
                                    {{ showAmount($data->amount) }}&nbsp;{{ __($general->cur_text) }}
                                </span>
                            </td>
                            <td data-label="@lang('Status')">
                                @if ($data->status == 1)
                                    <span class="badge badge--success">@lang('Completed')</span>
                                @elseif($data->status == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif($data->status == 3)
                                    <span class="badge badge--danger">@lang('Cancel')</span>
                                @endif

                                @if ($data->admin_feedback != null)
                                    <button class="btn btn--info badge detailBtn"
                                        data-admin_feedback="{{ $data->admin_feedback }}"><i
                                            class="fa fa-info"></i></button>
                                @endif

                            </td>
                            <td data-label="@lang('Time')">
                                <span class="time">{{ showDateTime($data->created_at) }}<br>{{ diffForHumans($data->created_at) }}</span>
                            </td>

                            @php
                                $details = $data->detail != null ? json_encode($data->detail) : null;
                            @endphp

                            <td data-label="@lang('Details')">
                                <a href="javascript:void(0)" class="approveBtn text--base"
                                    data-id="{{ $data->id }}"
                                    data-amount="{{ showAmount($data->amount) }} {{ __($general->cur_text) }}"
                                    data-charge="{{ showAmount($data->charge) }} {{ __($general->cur_text) }}"
                                    data-after_charge="{{ showAmount($data->amount + $data->charge) }} {{ __($general->cur_text) }}"
                                    data-rate="{{ showAmount($data->rate) }} {{ __($data->method_currency) }}"
                                    data-payable="{{ showAmount($data->final_amo) }} {{ __($data->method_currency) }}">
                                    <i class="las la-inbox fs-4"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{ $logs->links() }}

    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item dark-bg">@lang('Amount') : <span class="withdraw-amount "></span></li>
                        <li class="list-group-item dark-bg">@lang('Charge') : <span class="withdraw-charge "></span></li>
                        <li class="list-group-item dark-bg">@lang('After Charge') : <span
                                class="withdraw-after_charge"></span></li>
                        <li class="list-group-item dark-bg">@lang('Conversion Rate') : <span class="withdraw-rate"></span>
                        </li>
                        <li class="list-group-item dark-bg">@lang('Payable Amount') : <span class="withdraw-payable"></span>
                        </li>
                    </ul>
                    <ul class="list-group withdraw-detail">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--md btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--md btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .btn-close:focus{
            box-shadow: none;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                var amount = $(this).data('amount');
                console.log(amount);
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-rate').text($(this).data('rate'));
                modal.find('.withdraw-payable').text($(this).data('payable'));
                modal.modal('show');
            });

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
