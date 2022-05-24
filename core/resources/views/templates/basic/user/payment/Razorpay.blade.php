@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 mt-5">
        <div class="two__factor card custom--card">
            <div class="card-body border-radius-0 p-4">
                <h4 class="text-center">@lang('Please Pay') {{ showAmount($deposit->final_amo) }}
                    {{ $deposit->method_currency }}</h4>
                <h4 class="my-3 text-center">@lang('To Get') {{ showAmount($deposit->amount) }}
                    {{ __($general->cur_text) }}</h4>
                <form action="{{ $data->url }}" method="{{ $data->method }}">
                    <input type="hidden" custom="{{ $data->custom }}" name="hidden">
                    <script src="{{$data->checkout_js}}"
                        @foreach($data->val as $key=>$value)
                        data-{{$key}}="{{$value}}"
                    @endforeach >
                </script>
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
            $('input[type="submit"]').addClass("btn btn--base w-100 radius-5");
        })(jQuery);

    </script>
@endpush
