<div class="row g-3 justify-content-center">
    @forelse ($jobs as $job)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-10">
            <div class="job__item">
                <div class="job__item-thumb">
                    <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}">
                        <img src="{{ getImage(imagePath()['job']['attachment']['path'] . '/' . $job->attachment, imagePath()['job']['attachment']['size']) }}" alt="job">
                    </a>
                    <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="job-type btn btn--sm btn--primary">@lang('Detail')</a>
                </div>
                <div class="job__item-content">
                    <div class="wrapper d-flex justify-content-between align-items-center">
                        <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="tag btn btn--sm"><i class="las la-tag"></i>@lang('Vacancy Available')</a>
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
                        <a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}" class="btn btn--base btn--sm"
                            >@lang('APPLY')</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10">
        <h3 class="text--base text-center">{{ __($emptyMessage) }}</h3>
    </div>
    @endforelse
</div>
{{ $jobs->links() }}
