@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="contact-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="contact__form__wrapper">
                        <form action="{{ route('user.password.verify.code') }}" method="POST" class="contact__form gy-3">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form--group">
                                <label for="email" class="form-label">@lang('Verification Code')
                                    <span class="text--danger">*</span>
                                </label>
                                <input type="text" class="form-control form--control h-45" name="code" id="code">
                            </div>
                            <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit')</button>
                        </form>
                        <div class="form-group d-flex justify-content-between align-items-center mt-2">
                            @lang('Please check including your Junk/Spam Folder. if not found, you can')
                            <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a>
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