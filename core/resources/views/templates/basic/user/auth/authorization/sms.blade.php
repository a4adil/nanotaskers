@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="contact-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="contact__form__wrapper">
                    <h3 class="text-center">@lang('Please Verify Your Mobile to Get Access')</h3>
                    <form action="{{route('user.verify.sms')}}" method="POST" class="contact__form gy-3">
                        @csrf
                        <div class="form--group">
                            <p class="text-center">@lang('Your Mobile Number'):  <strong>{{auth()->user()->mobile}}</strong></p>
                        </div>
                        <div class="form--group">
                            <label for="email" class="form-label">@lang('Verification Code')
                                <span class="text--danger">*</span>
                            </label>
                            <input type="text" name="sms_verified_code" id="code" class="form-control form--control h-45">
                        </div>
                        <div class="form--group">
                            <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                    <div class="form--group">
                        <p>@lang('If you don\'t get any code'), <a href="{{route('user.send.verify.code')}}?type=phone" class="forget-pass text--base"> @lang('Try again')</a></p>
                        @if ($errors->has('resend'))
                            <br/>
                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush