@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="dashboard__content">
        <div class="row g-4 justify-content-center">
            @foreach($withdrawMethod as $data)
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="method__card text-center">
                        <h4>{{ __($data->name) }}</h4>
                        <div class="method__icon">
                            <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}">
                        </div>
                        <p>
                            <span class="admin">@lang('Charge'):
                                <strong>{{ $general->cur_sym }}{{ showAmount($data->fixed_charge) }}</strong>@lang('+')
                                <strong>{{ showAmount($data->percent_charge) }} @lang('%')</strong>
                            </span>
                        </p>
                        <p>
                            <span> @lang('Limit'):
                                <strong>{{ $general->cur_sym }}{{ showAmount($data->min_limit) }}</strong>@lang('-')
                                <strong>{{ $general->cur_sym }}{{ showAmount($data->max_limit) }}</strong>
                            </span>
                        </p>
                        <p class="mb-3">
                            <span> @lang('Processing Time'):
                                <strong>{{$data->delay}}</strong>
                            </span>
                        </p>
                        <a href="javascript:void(0)"  data-id="{{$data->id}}"
                            data-resource="{{$data}}"
                            data-min_amount="{{showAmount($data->min_limit)}}"
                            data-max_amount="{{showAmount($data->max_limit)}}"
                            data-fix_charge="{{showAmount($data->fixed_charge)}}"
                            data-percent_charge="{{showAmount($data->percent_charge)}}"
                            data-base_symbol="{{__($general->cur_text)}}"
                            class="btn btn--base btn--md w-100 radius-5 withdraw" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                            @lang('Withdraw Now')
                        </a>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Withdraw your Balance')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{route('user.withdraw.money')}}" method="post">
                @csrf
                <ul class="info m-0">
                    <li class="d-flex align-items-center">
                        <p class="title text-dark withdrawLimit"></p>
                    </li>
                    <li class="d-flex align-items-center">
                        <p class="title text-dark withdrawCharge"></p>
                    </li>
                </ul>
                <h5 class="mt-1 title text-dark">@lang('Your Current Balance :  '){{ $general->cur_sym }}{{ showAmount(Auth::user()->balance) }}</h5>
                <div class="input-group mt-2">
                    <input type="hidden" name="currency" class="edit-currency">
                    <input type="hidden" name="method_code" class="edit-method-code">
                    <input id="amount" type="text" class="form-control form--control radius-5 border border--dark" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">
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
    <!-- Withdraw Modal -->
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
        (function ($) {
            "use strict";
            $('.withdraw').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var withdrawLimit = `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{__($general->cur_text)}}`;
                $('.withdrawLimit').text(withdrawLimit);
                var withdrawCharge = `@lang('Charge'): ${fixCharge} {{__($general->cur_text)}} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.withdrawCharge').text(withdrawCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery);
    </script>

@endpush

