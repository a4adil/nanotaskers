@php
    $blog = getContent('blog.content',true);
    $blogs = getContent('blog.element',false,3,false);
@endphp
<section class="blog-section padding-top padding-bottom section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section__header text-center">
                    <h2 class="section__header-title">{{ __($blog->data_values->heading) }}</h2>
                    <p>{{ __($blog->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($blogs as $data)
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="post__item">
                    <div class="post__item-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/thumb_'.@$data->data_values->image,'550x400') }}" alt="@lang('announcement')">
                    </div>
                    <div class="post__item-content">
                        <h5 class="title"><a href="{{ route('blog.detail',$data->id) }}">{{ __($data->data_values->title) }}</a></h5>
                        <ul class="post-meta">
                            <li>
                                <span class="date"><i class="fas fa-calendar"></i> {{ showDateTime($data->created_at) }}</span>
                            </li>
                        </ul>
                        <p>{{ shortDescription($data->data_values->short_description) }}</p>
                        <a href="{{ route('blog.detail',$data->id) }}" class="read-more">@lang('Read More')</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
