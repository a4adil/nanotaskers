@php
    $service = getContent('service.content',true);
    $services = getContent('service.element',false,2);
@endphp
<section class="service-section  padding-bottom overflow-hidden">
    <div class="row justify-content-between g-0">
        <div class="col-lg-5 d-none d-lg-block">
            <div class="service__thumb h-100">
                <img src="{{ getImage('assets/images/frontend/service/'.$service->data_values->service_image,'1500x1001') }}" alt="@lang('service')">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="service__content padding-top padding-bottom ">
                <div class="container">
                    <div class="content__inner">
                        <div class="section__header mb-4">
                            <h2 class="section__header-title">{{ __($service->data_values->heading) }}</h2>
                            <p>{{ __($service->data_values->sub_heading) }}</p>
                            <a href="{{ __($service->data_values->url_link) }}" class="cmn--btn mt-3">{{ __($service->data_values->button) }}</a>
                        </div>
                        <div class="row g-4">
                            @foreach ($services as $item)
                            <div class="col-sm-6 col-xl-6">
                                <div class="service__item">
                                    <div class="service__item-icon">
                                        @php
                                            echo $item->data_values->service_icon;
                                        @endphp
                                    </div>
                                    <div class="service__item-content">
                                        <h4 class="title">{{ $item->data_values->title }}</h4>
                                        <p>{{ $item->data_values->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
