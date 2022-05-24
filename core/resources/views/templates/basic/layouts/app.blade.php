<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">


    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/jquery.datepicker2.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png', '?' . time()) }}" type="image/x-icon">

    <link rel="stylesheet"  href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">
    
    <link rel="stylesheet"  href="{{ asset($activeTemplateTrue . 'css/datepicker.min.css') }}">
    
        


    <title>{{ $general->sitename(__($pageTitle)) }}</title>

    @stack('style-lib')

    @stack('style')

</head>

<body>
    @php echo  fbComment() @endphp
    @include($activeTemplate.'partials.preloader')

    <div class="overlay"></div>

    @yield('app')

@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie__wrapper ">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-between">
            <p class="txt my-2">
               @php echo @$cookie->data_values->description @endphp
              <a class="text--base" href="{{ @$cookie->data_values->link }}" target="_blank">@lang('Read Policy')</a>
            </p>
              <a href="javascript:void(0)" class="btn btn--base my-2 policy">@lang('Accept')</a>
          </div>
        </div>
    </div>
 @endif



    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/nice-select.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/nicEdit.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.datepicker2.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/mainu.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.steps.js') }}"></script>




    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });
            $('.policy').on('click',function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.get('{{route('cookie.accept')}}', function(response){
                    $('.cookie__wrapper').addClass('d-none');
                    iziToast.success({message: response, position: "topRight"});
                });
            });
        })(jQuery);
    </script>
    <script>
        "use strict";
        bkLib.onDomLoaded(function() {
            $( ".nicEdit" ).each(function( index ) {
                $(this).attr("id","nicEditor"+index);
                new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
            });
        });
    </script>
</body>

</html>
