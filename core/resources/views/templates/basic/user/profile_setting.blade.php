@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard__content contact__form__wrapper">
    <div class="profile__edit__wrapper">
        <div class="profile__edit__form">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-5">
                    <div class="col-xl-4">
                        <div class="profile__thumb__edit text-center">
                            <div class="thumb">
                                <img id="previewImg"
                                    src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['size']) }}"
                                    alt="freelancer">
                            </div>
                            <div class="profile__info">
                                <h4 class="name">{{ $user->fullname }}</h4>
                                <p class="username">{{ $user->username }}</p>
                                <input type="file" class="form-control d-none" class="userProfileUpload"
                                    name="image" id="image" onchange="previewFile(this);">
                                <label class="btn btn--base btn--md mt-3" for="image">
                                    @lang('Update Profile Picture')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="profile__content__edit contact__form">
                            <div class="row gy-2">
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="fname" class="form-label">@lang('FirstName')</label>
                                        <input id="fname" name="firstname" type="text" class="form--control" value="{{ $user->firstname }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="lname" class="form-label">
                                            @lang('Last Name')
                                        </label>
                                        <input id="lname" type="text" name="lastname" class="form--control" value="{{ $user->lastname }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="username" class="form-label">
                                            @lang('User Name')
                                        </label>
                                        <input id="username" type="text" class="form--control" value="{{ $user->username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="email" class="form-label">@lang('Email
                                            Address')</label>
                                        <input id="email" type="email"class="form--control" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="country" class="form-label">@lang('Country')
                                        </label>
                                        <select name="country" id="country" class="form--control">
                                            <option value="" selected disabled>@lang('Select one')
                                            </option>
                                            @foreach ($countries as $key => $country)
                                                <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->country }}"
                                                    data-code="{{ $key }}"
                                                    @if (old('country') == $country->country) selected="selected" @endif
                                                    {{ $country->country == Auth::user()->address->country ? 'selected' : '' }}>
                                                    {{ __($country->country) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="number" class="form-label phone-label">@lang('Phone Number')</label>
                                        <div class="input-group">
                                            <span
                                                class="input-group-text mobile-code px-2 bg--none"></span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="text" name="mobile"
                                                class="form-control checkUser"
                                                placeholder="Phone number" aria-label="phone"
                                                aria-describedby="basic-addon1" value="">
                                        </div>
                                        <small class="text-danger mobileExist"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="state" class="form-label">@lang('State')</label>
                                        <input id="state" type="text" name="state" class="form--control" value="{{ @$user->address->state }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="number" class="form-label">@lang('City')</label>
                                        <input id="number" type="text" name="city" class="form--control" value="{{ @$user->address->city }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="zip" class="form-label">@lang('Zip
                                            Code')</label>
                                        <input id="zip" type="text" name="zip" class="form--control" value="{{ @$user->address->zip }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form--group">
                                        <label for="addr" class="form-label">@lang('Address')</label>
                                        <input id="addr" type="text" name="address" class="form--control" value="{{ @$user->address->address }}">
                                    </div>
                                </div>

                                <div class="col">
                                    <button class="btn btn--base w-100 btn--md">@lang('Update
                                        Profile')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/build/css/intlTelInput.css') }}">
    <style>
        .intl-tel-input {
            position: relative;
            display: inline-block;
            width: 100%;
             !important;
        }
        .btn--md{
            font-size: 14px !important;
        }
        .phone-label{
            z-index: 999;
        }

    </style>
@endpush
@push('script')

    <script>
        function previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
        $(document).ready(function() {
            var mobile = "{{ Auth::user()->mobile }}";
            var presentCode = $('input[name=mobile_code]').val();
            var result = mobile.slice(presentCode.length);
            $('input[name=mobile]').val(result);
        });
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
