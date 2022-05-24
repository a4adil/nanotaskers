
    @php
        $socialIcons = getContent('social_icon.element',false,null,true);
        $policyPages = getContent('policy_pages.element', false, null, true);
        $footer = getContent('footer.content', true);
    @endphp
    <footer class="footer-section bg_img bg_fixed"
        style="background: url({{ getImage('assets/images/frontend/footer/'.$footer->data_values->background_image,'1920x1080') }});">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-between gy-5">
                    <div class="col-xl-5 col-lg-6 col-md-10 col-sm-10">
                        <div class="footer__widget widget-about">
                            <div class="logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '?' . time()) }}" alt="logo">
                                </a>
                            </div>
                            <p>{{ $footer->data_values->heading }}</p>
                            <ul class="social-links mt-4">
                                @foreach ($socialIcons as $data)
                                <li>
                                    <a href="{{ $data->data_values->url }}">@php echo $data->data_values->social_icon @endphp</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5">
                        <div class="footer__widget">
                            <h4 class="widget-title">@lang('About Company')</h4>
                            <ul class="footer-links">
                                @foreach($pages as $k => $data)
                                    <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5">
                        <div class="footer__widget">
                            <h4 class="widget-title">@lang('Explore More')</h4>
                            <ul class="footer-links">
                                @foreach ($policyPages as $page)
                                <li><a href="{{ route('page.details', [$page->id, slug($page->data_values->title)]) }}">{{ $page->data_values->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer__bottom__wrapper d-flex flex-wrap justify-content-center">
                    <p class="copyright text--white">@php echo date('Y') @endphp&nbsp;&copy; @lang('All Rights Reserved by') <a class="text--base" href="{{ route('home') }}">{{ $general->sitename }}</a></p>
                </div>
            </div>
        </div>
    </footer>
