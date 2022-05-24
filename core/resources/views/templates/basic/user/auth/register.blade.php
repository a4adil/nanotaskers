@extends($activeTemplate.'layouts.app')
@section('app')
@php
    $data = getContent('register.content',true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

    <section class="account-section ">
        <div class="account__right bg_img"
            style="background: url({{ getImage('assets/images/frontend/register/'.$data->data_values->register_image,'1920x1080') }}) center;"></div>
        <div class="account-left sign-up">
            <div class="account__header">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '?' . time()) }}"
                        alt="@lang('logo')">
                </a>
                <h2 class="account__header-title">{{ __($data->data_values->heading) }}</h2>
                <p>{{ __($data->data_values->sub_heading) }}</p>
            </div>
            <form class="account-form row gx-3" action="{{ route('user.register') }}" method="POST"
                onsubmit="return submitUserForm();">
                @csrf
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="fname" class="form-label">@lang('First Name')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="fname" name="firstname" type="text" class="form--control" value="{{ old('firstname') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="lname" class="form-label">@lang('Last Name')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="lname" type="text" class="form--control" name="lastname" value="{{ old('lastname') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="country" class="form-label">@lang('Country')
                            <span class="text--danger">*</span>
                        </label>
                        <select name="country" id="country" class="form--control">
                            <option value="" selected disabled>@lang('Select one')</option>
                            @foreach ($countries as $key => $country)
                                <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}"
                                    data-code="{{ $key }}" @if (old('country') == $country->country) selected="selected" @endif>{{ __($country->country) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="phone" class="form-label">@lang('Phone Number')
                            <span class="text--danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text mobile-code px-2 bg--none"></span>
                            <input type="hidden" name="mobile_code">
                            <input type="hidden" name="country_code">
                            <input type="text" name="mobile" class="form-control  checkUser shadow-none outline-0"
                                aria-label="phone" aria-describedby="basic-addon1">
                        </div>
                        <small class="text-danger mobileExist"></small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="email" class="form-label">@lang('Email Address')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="email" type="email" class="form--control checkUser" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="username" class="form-label">@lang('Username')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="username" type="text" name="username" class="form--control checkUser" required>
                        <small class="text-danger usernameExist"></small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group hover-input-popup">
                        <label for="password" class="form-label">@lang('Password')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="password" type="password" name="password" class="form--control" required>
                        @if ($general->secure_password)
                            <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="pass2" class="form-label">@lang('Confrim Password')
                            <span class="text--danger">*</span>
                        </label>
                        <input id="pass2" type="password" name="password_confirmation" class="form--control" required>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="form--group">
                        <label for="username" class="form-label">@lang('Profile Type')
                            <span class="text--danger">*</span>
                        </label>
                        <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="user_type" value="1" checked>I'm a Worker
                        <label class="form-check-label" for="radio1"></label>
                        </div>
                        <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="user_type" value="2">I'm a Employee
                        <label class="form-check-label" for="radio2"></label>
                        </div>
                    </div>
                </div>
                
                <div class="form--group">
                    @php echo loadReCaptcha() @endphp
                </div>
                @include($activeTemplate.'partials.custom_captcha')
                @if ($general->agree)
                    <div class="col-12">
                        <div class="form--group custom--checkbox d-flex align-items-center">
                            <input id="agree" type="checkbox" class="form--control m-0 acceptPolicy" name="agree">
                            <label for="agree">@lang('I accept all')&nbsp;
                            </label>
                            <div class="policyPage">
                                @foreach ($policyPages as $page)
                                    <a href="{{ route('page.details', [$page->id, slug($page->data_values->title)]) }}" class="text--base">{{ $page->data_values->title }}</a>@if(!$loop->last)@lang(',') @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <button type="submit" class="btn btn--base btn--round w-100">@lang('Sign Up')</button>
                </div>
            </form>
            <div class="account__footer ps-2">
                <p class="account__footer-registration">@lang('Already Registered?')
                    <a class="text--base fw-bolder ms-2" href="{{ route('user.login') }}">@lang('Sign In Here')</a>
                </p>
            </div>
        </div>
    </section>
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h6 class="text-center">@lang('You already have an account please Sign in ')</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger" data-bs-dismiss="modal">Close</button>
              <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('style')
    <style>
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

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
            z-index: 11;
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
        (function($) {
            @if ($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input',function(){
                secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response['data'] && response['type'] == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);



    </script>
@endpush
