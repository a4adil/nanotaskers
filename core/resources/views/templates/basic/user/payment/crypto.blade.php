@extends($activeTemplate.'layouts.master')

@section('content')

<div class="two__factor card custom--card primary-bg">
    <div class="card-body border-radius-0 p-4">
        <div class="row">
            <div class="col-md-4">
                <h3 class="title mb-2"><span>@lang('Payment Preview')</span></h3>
                <img src="{{ $deposit->gatewayCurrency()->methodImage() }}" class="card-img-top"
                    alt="@lang('Image')" class="w-100">
            </div>
            <div class="col-md-8 text-center">
                    <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                    <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                    <img src="{{$data->img}}" alt="@lang('Image')">
                    <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
            </div>
        </div>
    </div>
</div>
@endsection

