@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                @include($activeTemplate.'partials.sidebar')
                <div class="col-lg-8 col-xl-9">
                    @include($activeTemplate.'partials.responsive_header')
                    <div class="row">
                        <div class="col-xl-6">
                            @if (Auth::user()->ts)
                                <div class="two__factor card custom--card primary-bg h-100">
                                    <div class="card-header">
                                        <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                    </div>
                                    <div class="card-body border-radius-0 p-3">
                                        <div class="text-center">
                                            <button type="button" class="btn btn--base w-100 radius-5"
                                                data-bs-toggle="modal" data-bs-target="#disableModal">@lang('Disable Two
                                                Factor
                                                Authenticator')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="two__factor card custom--card primary-bg h-100">
                                    <div class="card-header">
                                        <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                    </div>
                                    <div class="card-body border-radius-0 p-3">
                                        <div class="two-factor-content">
                                            <div class="input-group mt-2">
                                                <input type="text" name="key" value="{{ $secret }}"
                                                    class="form-control form--control" id="referralURL" readonly>
                                                <div class="btn btn--base text--white btn--md copybtn"><i
                                                        class="las la-copy"></i>
                                                </div>
                                            </div>
                                            <div class="two-factor-scan text-center my-3">
                                                <img class="mw-100" src="{{ $qrCodeUrl }}" alt="account">
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn--base w-100 radius-5"
                                                    data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two
                                                    Factor
                                                    Authenticator')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <div class="two__factor card custom--card primary-bg">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                </div>
                                <div class="card-body border-radius-0 p-3">
                                    <div class="two-factor-content">

                                        <div class="two-factor-scan text-center">
                                            <p>@lang('Google Authenticator is a multifactor app for mobile devices. It
                                                generates timed codes used during the 2-step verification process. To use
                                                Google Authenticator, install the Google Authenticator application on your
                                                mobile device.')
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn--base w-100 radius-5 mt-2"
                                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                                target="_blank">@lang('DOWNLOAD APP')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Two Factor Modal -->
    <div class="modal fade custom--modal two__factor__modal" id="enableModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp')</h5>
                </div>
                <form action="{{ route('user.twofactor.enable') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="hidden" name="key" value="{{ $secret }}">
                            <input type="text" class="form-control form--control radius-0" name="code"
                                placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--sm btn--primary">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Two Factor Modal -->
    <!-- Two Factor Modal -->
    <div class="modal fade custom--modal two__factor__modal" id="disableModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp Disable')</h5>
                </div>
                <form action="{{ route('user.twofactor.disable') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control form--control radius-0" name="code"
                                placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--md btn--danger"
                            data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--md btn--success">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Two Factor Modal -->

@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.copytext').on('click', function() {
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({
                    message: "Copied: " + copyText.value,
                    position: "topRight"
                });
            });
        })(jQuery);
    </script>
@endpush
