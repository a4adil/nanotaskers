@extends($activeTemplate.'layouts.app')
@section('app')

    @include($activeTemplate.'partials.header')

    @if (!request()->routeIs('home'))
        @include($activeTemplate .'partials.breadcrumb')
    @endif

    @yield('content')

    @include($activeTemplate.'partials.preloader')

    <a href="#0" class="scrollToTop active"><i class="las la-rocket"></i></a>
    
    @include($activeTemplate.'partials.cta')
    @include($activeTemplate.'partials.footer')

@endsection
