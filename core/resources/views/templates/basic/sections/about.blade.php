@php
    $about = getContent('about.content',true);
    $abouts = getContent('about.element',false,5);
@endphp
<section class="about-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="about__content">
                    <div class="section__header m-0">
                        <h2 class="section__header-title">{{ $about->data_values->heading }}</h2>
                        <p>{{ $about->data_values->sub_heading }}</p>
                        <ul class="about__info">
                            @foreach ($abouts as $data)                  
                                <li>{{ $data->data_values->item }} </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="about__thumb">
                    <img class="thumb1" src="{{ getImage('assets/images/frontend/about/'.$about->data_values->image_two,'650x705') }}" alt="thumb">
                    <img class="thumb2" src="{{ getImage('assets/images/frontend/about/'.$about->data_values->image_one,'650x658') }}" alt="thumb">
                </div>
            </div>
        </div>
    </div>
</section>


