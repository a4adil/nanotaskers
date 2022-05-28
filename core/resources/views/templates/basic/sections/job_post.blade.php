@php
    $data = getContent('job_post.content',true);
    
     if (!empty($country_code))
        $jobs      = App\Models\JobPost::select('*')->leftJoin('continent_countries', 'job_posts.id', '=', 'continent_countries.post_id')->where(['continent_countries.country' => session('country_code')])->latest('job_posts.created_at')->take(8)->get();
    else
        $jobs      = App\Models\JobPost::where('status', 1)->latest()->take(8)->get();
    
    
    $jobproves      = App\Models\JobProve::where(['status' => 1, 'user_id' => session('id')])->count();
@endphp

   
<section class="job-section padding-top padding-bottom section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section__header text-center">
                    <h2 class="section__header-title">{{ __($data->data_values->heading) }}</h2>
                    <p>{{ __($data->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach ($jobs as $job)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10">
                    <div class="job__item">
                        <div class="job__item-thumb">
                            <img src="{{ getImage(imagePath()['job']['attachment']['path'] . '/' . $job->attachment, imagePath()['job']['attachment']['size']) }}" alt="job">
                            <span style="float: left !important; position: absolute;    top: 11px; z-index: 1000;    left: 7px;" class=" btn btn--sm btn--primary">@if($jobproves < 500) Starter @elseif($jobproves > 500 && $jobproves < 1000) @endif</span>
                            <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="job-type btn btn--sm btn--primary">@lang('Detail')</a>
                        </div>
                        <div class="job__item-content">
                            <div class="wrapper d-flex justify-content-between align-items-center">
                                <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="tag btn btn--sm"><i class="las la-tag"></i>@lang(' Vacancy Available')</a>
                                <a class="job-author text--primary tag btn btn--sm" href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}">{{ $job->vacancy_available }}</a>
                            </div>
                            <h5 class="title"><a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}">{{ __($job->title) }}</a></h5>
                            <ul class="job__info">
                                <li>
                                    <h6 class="job__info-title">@lang('published ')</h6>
                                    <span class="text--primary">{{ showDateTime($job->created_at) }}</span>
                                </li>
                            </ul>
                            <div class="content__footer d-flex align-items-center justify-content-between">
                                <h3 class="price">{{ $general->cur_sym }}{{ showAmount($job->rate) }}</h3>
                                <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="btn btn--base btn--sm">@lang('APPLY')</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 mt-4">
                <div class="section__header text-center">
                   <a href="{{ route('all.jobs') }}" class="btn btn--base btn--lg">@lang('View all')</a>
                </div>
            </div>
        </div>
    </div>
</section>
