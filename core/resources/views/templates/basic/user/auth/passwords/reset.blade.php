@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="contact-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="contact__form__wrapper">
                    <form action="{{ route('user.password.update') }}" method="POST" class="contact__form gy-3">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form--group hover-input-popup">
                            <label for="email" class="form-label">@lang('Password:')
                                <span class="text--danger">*</span>
                            </label>
                            <input id="password" type="password" class="form-control form--control h-45 @error('password') is-invalid @enderror" name="password" required>
                            @if($general->secure_password)
                                <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                                </div>
                            @endif
                        </div>
                        <div class="form--group">
                            <label for="email" class="form-label">@lang('Confirm Password:')
                                <span class="text--danger">*</span>
                            </label>
                            <input class="form-control form--control h-45" id="password-confirm" type="password"  name="password_confirmation" required>
                        </div>
                        <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit')</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
{{-- <section class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12 m-auto">
                <div class="dashboard__content">
                    <div class="row gy-5">
                        <div class="col-xl-8 m-auto">
                            <div class="pass__change">
                                <form method="POST" action="{{ route('user.password.update') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="input-group mb-3 mb-sm-4 hover-input-popup">
                                        <label class="form-label">@lang('Password : ')</label>
                                        <input id="password" type="password" class="form-control form--control h-45 @error('password') is-invalid @enderror" name="password" required>
                                        @if($general->secure_password)
                                            <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 mb-sm-4">
                                        <label class="form-label">@lang('Confirm Password : ')</label>
                                        <input class="form-control form--control h-45" id="password-confirm" type="password"  name="password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn--base btn--md w-100">@lang('Reset Password')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection
@push('style')
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush