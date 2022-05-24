@extends($activeTemplate.'layouts.app')

@section('app')
@php
    $data = getContent('login.content',true);
@endphp
    <section class="account-section">
        <div class="account-left">
            <div class="account__header">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '?' . time()) }}"
                        alt="@lang('logo')">
                </a>
                <h2 class="account__header-title">{{ __($data->data_values->heading) }}</h2>
                <p>{{ __($data->data_values->sub_heading) }}</p>
            </div>
            <form class="account-form" method="POST" action="{{ route('user.login') }}" onsubmit="return submitUserForm();">
                @csrf
                <div class="form--group">
                    <label for="uname" class="form-label">@lang('Username or Email')
                        <span class="text--danger">*</span>
                    </label>
                    <input id="uname" type="text" class="form--control" name="username" value="{{ old('username') }}" class="form-control" required>
                </div>
                <div class="form--group">
                    <label for="password" class="form-label">@lang('Password') <span class="text--danger">*</span>
                    </label>
                    <input id="password" type="password" name="password" class="form--control" required>
                </div>
                <div class="form--group">
                    @php echo loadReCaptcha() @endphp
                </div>
                @include($activeTemplate.'partials.custom_captcha')
                <div class="row gx-0">
                    <div class="col-6">
                        <div class="form--group custom--checkbox d-flex align-items-center">
                            <input id="remember" type="checkbox" name="remember" class="form--control m-0"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">@lang('Remember Me')</label>
                        </div>
                    </div>
                    <div class="col-6 login-forgot-password">
                        <a href="{{ route('user.password.request') }}"
                            class="forgot-pass text--base font-weight-bold">@lang('Forgot Password?')
                        </a>
                    </div>
                </div>
                <div class="form--group">
                    <button type="submit" class="btn btn--base btn--round w-100">@lang('Sign In')</button>
                </div>
            </form>
            <div class="account__footer">
                <p class="account__footer-registration">@lang('Not a Member of Microworks?')
                    <a class="text--base fw-bolder ms-2" href="{{ route('user.register') }}">@lang('Sign Up Here')
                    </a>
                </p>
            </div>
        </div>
        <div class="account__right bg_img"
            style="background: url({{ getImage('assets/images/frontend/login/'.$data->data_values->login_image,'1920x1080') }})">
        </div>
    </section>

@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
