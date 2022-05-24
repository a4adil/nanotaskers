@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="two__factor card custom--card">
            <div class="card-header">
                <h5 class="card-title">@lang('Payment Preview')</h5>
            </div>
            <div class="card-body border-radius-0 p-4">
                <form action="{{ route('ipn.' . $deposit->gateway->alias) }}" method="POST"
                    class="text-center">
                    @csrf
                    <h4>@lang('Please Pay') {{ showAmount($deposit->final_amo) }}
                        {{ __($deposit->method_currency) }}</h4>
                    <h4 class="my-3">@lang('To Get') {{ showAmount($deposit->amount) }}
                        {{ __($general->cur_text) }}</h4>
                    <button type="button" class="btn btn--base w-100 radius-5" id="btn-confirm">@lang('Pay
                        Now')</button>
                    <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}"
                        data-email="{{ $data->email }}" data-amount="{{ $data->amount }}"
                        data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}"
                        data-custom-button="btn-confirm">
                    </script>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
