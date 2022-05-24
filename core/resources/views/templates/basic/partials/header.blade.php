@php
    $socialIcons = getContent('social_icon.element',false,null,true);
    $datas = getContent('contact_us.element',false,2,true);
@endphp
    <div class="header-top">
        <div class="container">
            <div class="header__top__wrapper d-flex flex-wrap justify-content-center justify-content-lg-between align-items-center">
                <div class="header__top__wrapper-left">
                    <ul class="contacts  d-flex flex-wrap justify-content-center m-0">
                        @foreach ($datas as $data)
                            <li><a href="{{ __($data->data_values->attribute) }}{{ $data->data_values->content }}">@php echo $data->data_values->icon @endphp {{ __($data->data_values->content) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="header__top__wrapper-right d-flex align-items-center">
                    <ul class="social-links m-0 me-3">
                        @foreach ($socialIcons as $data)
                            <li>
                                <a href="{{ $data->data_values->url }}">@php echo $data->data_values->social_icon @endphp</a>
                            </li>
                        @endforeach
                    </ul>
                    <select class="language langSel nice-select">
                        @foreach ($language as $item)
                            <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected  @endif>{{ __($item->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-bottom-area">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png', '?' . time()) }}"
                            alt="@lang('logo')">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <!--@foreach($pages as $k => $data)-->
                    <!--    <li>-->
                    <!--        <a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a>-->
                    <!--    </li>-->
                    <!--@endforeach-->
                    <!--<li>-->
                    <!--    <a href="{{ route('all.jobs') }}">@lang('Jobs')</a>-->
                    <!--</li>-->
                    <!--<li>-->
                    <!--    <a href="{{ route('blogs') }}">@lang('Blogs')</a>-->
                    <!--</li>-->
                    <li>
                        <a href="https://nanotaskers.com/page/82/payment-policy">@lang('Payment Policy')</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">@lang('Contact Us')</a>
                    </li>
                    <li class="p-0">
                        @guest
                            <a class="btn btn--base btn--round btn--md ms-2 my-2 my-lg-0 text-white"
                                href="{{ route('user.login') }}">@lang('Login')
                            </a>
                            <a class="btn btn--base btn--round btn--md ms-2 text-white"
                                href="{{ route('user.register') }}">@lang('Register')
                            </a>
                        @else
                            <a class="btn btn--base btn--round btn--md ms-2 text-white"
                                href="{{ route('all.jobs') }}">@lang('Find Jobs')
                            </a>
                        @endguest

                    </li>
                </ul>


                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-top-trigger lh-1 p-1">
                        <i class="las la-ellipsis-v"></i>
                    </div>
                    <div class="header-trigger d-block d--none">
                        <span></span>
                    </div>
                </div>

            </div>
        </div>
    </div>

