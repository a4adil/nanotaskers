@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$banner = getContent('banner.content',true);
@endphp
<section class="banner-section bg_img overflow-hidden" style="background: url({{ getImage('assets/images/frontend/banner/'.$banner->data_values->background_image,'1920x1129') }});">
    <div class="container">
        <div class="banner__wrapper d-flex align-items-center">
            <div class="banner__content">
                <span class="subtitle">{{ __($banner->data_values->heading) }}</span>
                <h1 class="banner__content-title">{{ __($banner->data_values->sub_heading) }}</h1>
                <p>{{ __($banner->data_values->short_details) }}</p>
                <form class="job__search" action="{{ route('job.search') }}">
                    <div class="form--group d-flex align-items-center">
                        <select class="nice-select border-0" name="category">
                            <option value="" selected disabled>@lang('Select Category')</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control form--control" name="search" autocomplete="off" placeholder="@lang('Search for your Jobs')">
                        <button class="btn btn--base btn--round px-md-5" type="submit">{{ __($banner->data_values->button) }}</button>
                    </div>
                </form>
                <div class="popular__tags">
                    <h6 class="title d-inline-block">{{ __($banner->data_values->keyword_title) }}</h6>
                    <ul class="tags-list">
                        @foreach ($keywords as $data)
                            <li><a href="{{ route('all.subcategory', ['id' => $data->category_id, 'name' => slug($data->category->name)]) }}">{{ __($data->category->name) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="banner__thumb d-none d-lg-block">
                <img src="{{ getImage('assets/images/frontend/banner/'.$banner->data_values->banner_image,'750x607') }}" alt="@lang('thumb')">
            </div>
        </div>
    </div>
</section>


    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif

@endsection

