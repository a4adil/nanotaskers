@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard__content">
    <div class="row g-4 justify-content-center">
        @foreach ($gatewayCurrency as $data)
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="method__card text-center">
                    <h4>{{ __($data->name) }}</h4>
                    <div class="method__icon">
                        <img src="{{ $data->methodImage() }}">
                    </div>
                    <p>
                        <span class="admin">@lang('Charge'):
                            <strong>{{ $general->cur_sym }}{{ showAmount($data->fixed_charge) }}</strong>@lang('+')
                            <strong>{{ showAmount($data->percent_charge) }} @lang('%')</strong>
                        </span>
                    </p>
                    <p class="mb-3">
                        <span> @lang('Limit'):
                            <strong>{{ $general->cur_sym }}{{ showAmount($data->min_amount) }}</strong>@lang('-')
                            <strong>{{ $general->cur_sym }}{{ showAmount($data->max_amount) }}</strong>
                        </span>
                    </p>
                    <a href="javascript:void(0)" data-id="{{ $data->id }}"
                        data-name="{{ $data->name }}" data-currency="{{ $data->currency }}"
                        data-method_code="{{ $data->method_code }}"
                        data-min_amount="{{ showAmount($data->min_amount) }}"
                        data-max_amount="{{ showAmount($data->max_amount) }}"
                        data-base_symbol="{{ $data->baseSymbol() }}"
                        data-fix_charge="{{ showAmount($data->fixed_charge) }}"
                        data-percent_charge="{{ showAmount($data->percent_charge) }}"
                        class="btn btn--base btn--md w-100 radius-5 deposit" data-bs-toggle="modal"
                        data-bs-target="#depositModal">
                        @lang('Deposit Now')
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('Deposit your Balance')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="{{ route('user.deposit.insert') }}" method="post">
            @csrf
            <ul class="info">
                <li class="d-flex align-items-center">
                    <p class="title depositLimit text-dark"></p>
                </li>
                <li class="d-flex align-items-center">
                    <p class="title depositCharge text-dark"></p>
                </li>
            </ul>
            <div class="input-group mt-2">
                <input type="hidden" name="currency" class="edit-currency">
                <input type="hidden" name="method_code" class="edit-method-code">
                <input id="amount" type="text" class="form-control form--control radius-5 border border--dark" name="amount"
                placeholder="@lang('Amount')" required value="{{ old('amount') }}">
                <span class="input-group-text" id="basic-addon2">{{ $general->cur_text }}</span>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn--sm btn-dark" data-bs-dismiss="modal">@lang('Cancel')</button>
            <button type="submit" class="btn btn--sm btn btn--base">@lang('Confirm')</button>
        </div>
    </form>
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
            $('.deposit').on('click', function() {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{ $general->cur_text }}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge =
                    `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });

            // $('.prevent-double-click').on('click',function(){
            //     $(this).addClass('button-none');
            //     $(this).html('<i class="fas fa-spinner fa-spin"></i> @lang('Processing')...');
            // });
        })(jQuery);
    </script>
@endpush


@push('style')
    <style type="text/css">

    </style>
@endpush
