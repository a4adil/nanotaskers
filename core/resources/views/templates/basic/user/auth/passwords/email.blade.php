@extends($activeTemplate.'layouts.frontend')

@section('content')

<section class="contact-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="contact__form__wrapper">
                    <form class="contact__form gy-3" method="post" action="{{ route('user.password.email') }}">
                        @csrf
                        <div class="form--group">
                            <label class="form-label">@lang('Select One:')</label>
                            <select class="form-control form--control" name="type">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <label for="email" class="form-label my_value">
                                <span class="text--danger">*</span>
                            </label>
                            <input type="text" class="form-control form--control h-45 @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">
                        </div>
                        <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit')</button>
                    </form>
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
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush