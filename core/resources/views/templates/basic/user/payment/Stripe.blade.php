@extends($activeTemplate.'layouts.master')
@section('content')

<div class="two__factor card custom--card primary-bg">
    <div class="card-body border-radius-0 p-4">
        <div class="card-wrapper my-2"></div>
        <form role="form" id="payment-form" method="{{ $data->method }}" action="{{ $data->url }}">
            @csrf
            <input type="hidden" value="{{ $data->track }}" name="track">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">@lang('Name on Card')</label>
                    <div class="input-group">
                        <input type="text" class="form-control form--control" name="name"
                            placeholder="@lang('Name on Card')" autocomplete="off" autofocus />
                        <div class="btn btn--base text--white btn--md copybtn">
                            <i class="fa fa-font"></i>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <label for="cardNumber">@lang('Card Number')</label>
                    <div class="input-group">
                        <input type="tel" class="form-control form--control" name="cardNumber"
                            placeholder="@lang('Valid Card Number')" autocomplete="off" required
                            autofocus />
                        <div class="btn btn--base text--white btn--md copybtn">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="cardExpiry">@lang('Expiration Date')</label>
                    <input type="tel" class="form-control form--control" name="cardExpiry"
                        placeholder="@lang('MM / YYYY')" autocomplete="off" required />
                </div>
                <div class="col-md-6 ">
                    <label for="cardCVC">@lang('CVC Code')</label>
                    <input type="tel" class="form-control form--control" name="cardCVC"
                        placeholder="@lang('CVC')" autocomplete="off" required />
                </div>
            </div>
            <br>
            <button class="btn btn--base w-100 radius-5" type="submit"> @lang('PAY NOW')</button>
        </form>
    </div>
</div>
@endsection


@push('script')
    <script src="{{ asset('assets/global/js/card.js') }}"></script>

    <script>
        (function($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
@endpush
