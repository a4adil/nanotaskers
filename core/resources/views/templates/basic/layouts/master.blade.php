@extends($activeTemplate.'layouts.app')
@section('app')

    @include($activeTemplate.'partials.header')
    @include($activeTemplate .'partials.breadcrumb')

    <section class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                @include($activeTemplate.'partials.sidebar')
                <div class="col-lg-8 col-xl-9">
                    @include($activeTemplate.'partials.responsive_header')
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    @include($activeTemplate.'partials.preloader')

    <a href="#0" class="scrollToTop active"><i class="las la-rocket"></i></a>

    @include($activeTemplate.'partials.cta')
    @include($activeTemplate.'partials.footer')

@endsection
