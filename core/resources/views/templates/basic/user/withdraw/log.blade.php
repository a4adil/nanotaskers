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
                @forelse ($withdraws as $k => $data)
                        <tr>
                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                            <td data-label="@lang('Gateway')">{{ __($data->method->name) }}</td>
                            <td data-label="@lang('Amount')">
                                <strong>{{__($general->cur_sym)}}{{showAmount($data->amount)}}</strong>
                            </td>
                            <td data-label="@lang('Status')">
                                @if($data->status == 2)
                                    <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif($data->status == 1)
                                    <span class="badge badge--success">@lang('Completed')</span>
                                    <span class="badge badge--info badge-dot approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></span>
                                @elseif($data->status == 3)
                                    <span class="badge badge--warning">@lang('Rejected')</span>
                                    <span class="badge badge--info badge-dot approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></span>
                                @endif
                            </td>
                            <td data-label="@lang('Time')">
                                {{showDateTime($data->created_at)}}<br>{{ diffForHumans($data->created_at) }}
                            </td>
                            <td data-label="@lang('Details')">
                                <a href="javascript:void(0)" class="detailBtn text--base"
                                    data-id="{{ $data->id }}"
                                    data-transaction="{{$data->trx}}"
                                    data-gateway="{{ __($data->method->name) }}"
                                    data-amount="{{__($general->cur_sym)}}{{showAmount($data->amount)}}"
                                    data-charge="{{__($general->cur_sym)}}{{showAmount($data->charge)}}"
                                    data-after_charge="{{__($general->cur_sym)}}{{showAmount($data->after_charge)}}"
                                    data-rate="{{showAmount($data->rate)}}&nbsp;{{__($data->method->currency)}}"
                                    data-receivable="{{showAmount($data->final_amount)}}&nbsp;{{__($data->method->currency)}}">
                                    <i class="las la-inbox fs-4"></i>
                                </a>
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td class="justify-content-center text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{$withdraws->links()}}

    <div id="viewModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item dark-bg">@lang('Transaction ID') : <span class="transaction"></span></li>
                        <li class="list-group-item dark-bg">@lang('Gateway') : <span class="gateway"></span></li>
                        <li class="list-group-item dark-bg">@lang('Amount') : <span class="amount"></span></li>
                        <li class="list-group-item dark-bg">@lang('Charge') : <span class="charge"></span></li>
                        <li class="list-group-item dark-bg">@lang('After Charge') : <span class="aftercharge"></span></li>
                        <li class="list-group-item dark-bg">@lang('Rate') : <span class="rate"></span></li>
                        <li class="list-group-item dark-bg">@lang('Receivable') : <span class="receivable"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--md btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                </div>
                <div class="modal-body">

                    <div class="withdraw-detail"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--sm btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> Your Transaction ID : ${feedback} </p>`);
                modal.modal('show');
            });

            $('.detailBtn').on('click', function() {
                var modal = $('#viewModal');
                console.log(modal);
                modal.find('.transaction').text($(this).data('transaction'));
                modal.find('.gateway').text($(this).data('gateway'));
                modal.find('.amount').text($(this).data('amount'));
                modal.find('.charge').text($(this).data('charge'));
                modal.find('.aftercharge').text($(this).data('after_charge'));
                modal.find('.rate').text($(this).data('rate'));
                modal.find('.receivable').text($(this).data('receivable'));
                modal.modal('show');
            });

        })(jQuery);

    </script>
@endpush

