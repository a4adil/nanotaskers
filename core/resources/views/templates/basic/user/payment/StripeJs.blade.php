@extends($activeTemplate.'layouts.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="two__factor card custom--card primary-bg">
            <div class="card-body border-radius-0 p-4">
                <form action="{{ $data->url }}" method="{{ $data->method }}">
                    <h3 class="text-center">@lang('Please Pay') {{ showAmount($deposit->final_amo) }}
                        {{ __($deposit->method_currency) }}</h3>
                    <h3 class="my-3 text-center">@lang('To Get') {{ showAmount($deposit->amount) }}
                        {{ __($general->cur_text) }}</h3>
                        <script src="{{$data->src}}"
                            class="stripe-button"
                            @foreach($data->val as $key=> $value)
                            data-{{$key}}="{{$value}}"
                            @endforeach
                        >
                        </script>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("w-100");
        })(jQuery);

    </script>
@endpush
