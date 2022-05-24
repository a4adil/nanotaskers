@php
  $data = getContent('cta.content',true);
 @endphp
<div class="@if(request()->routeIs('home')) section-bg @endif">
    <div class="container">
        <div class="get-started d-flex flex-wrap align-items-center justify-content-between">
            <div class="section__header m-0">
                <h3 class="section__header-title">{{ __($data->data_values->heading) }}</h3>
                <p>{{ __($data->data_values->sub_heading) }}</p>
            </div>
            <a href="{{ $data->data_values->button_url }}" class="cmn--btn">{{ __($data->data_values->button) }}</a>
        </div>
    </div>
</div>
