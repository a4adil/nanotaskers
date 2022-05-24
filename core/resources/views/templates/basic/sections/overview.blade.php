@php
    $data = getContent('overview.content',true);
@endphp
<section class="overview-section bg_img overflow-hidden" style="background: url({{ getImage('assets/images/frontend/overview/'.$data->data_values->background_image,'1920x1129') }});">
    <div class="row">
        <div class="col-lg-6 p-0">
            <div class="overview__content__wrapper bg_img" style="background: url({{  getImage('assets/images/frontend/overview/'.$data->data_values->overview_image,'500x204') }});">
                <div class="container">
                    <div class="overview__content ms-lg-auto padding-top padding-bottom">
                        <div class="section__header mb-0 color-white">
                            <h2 class="section__header-title">{{ __($data->data_values->heading_one) }}</h2>
                            <p>{{ __($data->data_values->sub_heading_one) }}</p>
                            <a href="{{ $data->data_values->link_one }}" class="btn">{{ __($data->data_values->button_one) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 p-0">
            <div class="overview__content__wrapper right-bg bg_img">
                <div class="container">
                    <div class="overview__content ps-lg-4 ps-xxl-5 padding-top padding-bottom">
                        <div class="section__header mb-0">
                            <h2 class="section__header-title">{{ __($data->data_values->heading_two) }}</h2>
                            <p>{{ __($data->data_values->sub_heading_one) }}</p>
                            <a href="{{ $data->data_values->link_two }}" class="btn">{{ __($data->data_values->button_two) }}</a>
                        </div>
                    </div>
                </div>
                <img src="{{  getImage('assets/images/frontend/overview/'.$data->data_values->overview_image,'500x204') }}" alt="overview" class="shape1">
            </div>
        </div>
    </div>
</section>