@extends($activeTemplate.'layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="two__factor card custom--card">
            <div class="card-body border-radius-0">
                <h4 class="mt-4 text-center">@lang('Please Pay') {{ showAmount($deposit->final_amo) }}
                    {{ __($deposit->method_currency) }}
                </h4>
                <h4 class="my-3 text-center">@lang('To Get') {{ showAmount($deposit->amount) }}
                    {{ __($general->cur_text) }}</h4>
                <button type="button" class="btn btn--base w-100 radius-5" id="btn-confirm"
                    onClick="payWithRave()">@lang('Pay Now')</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{ $data->API_publicKey }}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{ $data->customer_email }}",
                amount: "{{ $data->amount }}",
                customer_phone: "{{ $data->customer_phone }}",
                currency: "{{ $data->currency }}",
                txref: "{{ $data->txref }}",
                onclose: function () {},
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref +
                            '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref +
                            '/' + status;
                    }
                    // x.close(); // use this to close the modal immediately after payment.
                }
            });
        }

    </script>
@endpush
