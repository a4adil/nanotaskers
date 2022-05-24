@extends($activeTemplate .'layouts.frontend')
@section('content')
    <section class="counter-section padding-top padding-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6 m-auto">
                    <div class="contact__form__wrapper">
                        <h3 class="contact__form__wrapper-title">@lang('Please Verify Your Email to Get Access')</h3>
                        <form class="contact__form" action="{{ route('user.verify.email') }}" method="POST"
                            class="login-form">
                            @csrf
                            <div class="form--group">
                                <p class="text-center">@lang('Your Email'):
                                    <strong>{{ auth()->user()->email }}</strong>
                                </p>
                            </div>
                            <div class="form--group">
                                <label class="form--label" for="">@lang('Verification Code') <span
                                        class="text--danger">*</span></label>
                                <input id="email" type="text" name="email_verified_code" class="form--control"
                                    maxlength="7" id="code">
                            </div>
                            <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit')</button>

                            <div class="form--grou mt-2">
                                <p>@lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{ route('user.send.verify.code') }}?type=email"
                                        class="forget-pass text--danger">
                                        @lang('Resend code')
                                    </a>
                                </p>
                                @if ($errors->has('resend'))
                                    <br />
                                    <small class="text--danger">{{ $errors->first('resend') }}</small>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#code').on('input change', function() {
                var xx = document.getElementById('code').value;

                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)
    </script>
@endpush
