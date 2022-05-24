@extends($activeTemplate.'layouts.frontend')
@section('content')


<section class="blog-section padding-top padding-bottom ">
    <div class="container">
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
        {{ $blogs->links() }}
    </div>
</section>

@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif

@endsection
