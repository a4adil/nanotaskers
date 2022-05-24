@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard__content">
    <div class="finished__jobs__wrapper">
        <div class="finished__jobs__header d-flex flex-wrap justify-content-between align-items-center mb-2">
            <h4 class="pe-4 mb-2">@lang('Job ID : ') {{ __($job->job_code) }}</h4>
            <h4 class="pe-4 mb-2">@lang('Budget : ') {{ $general->cur_sym }}{{ showAmount($job->total) }}</h4>
            <h4 class="pe-4 mb-2">@lang('Workers : ') {{ __($job->workers) }}</h4>
            <a href="{{ route('user.job.history') }}" class="btn btn--sm btn--base mb-2">@lang('Go Back')</a>
        </div>
        @forelse ($job->proof->sortByDesc('id') as $data)
        <div class="finished__job__item">
            <div class="row w-100 justify-content-between g-0 gy-3">
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="job__header me-3">
                        <h5 class="job__header-title"><a href="{{ route('job.details',['id' => $job->id, 'title' => slug($job->title)]) }}">{{ __($job->title) }}</a></h5>
                        <p class="job-post-date">{{ showDateTime($job->created_at) }}</p>
                        <h3 class="job__price d-inline-block"><sub>{{ $general->cur_sym }}</sub> {{ showAmount($job->rate) }}</h3>
                    </div>
                </div>
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="job__body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="employer__wrapper d-inline-flex flex-wrap align-items-center">
                            <div class="employer__thumb me-3">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $data->user->image, imagePath()['profile']['user']['size']) }}" alt="lang('Freelancer')">
                            </div>
                            <div class="content">
                                <h6 class="employer__name">{{ $data->user->username }}</h6>
                                @if ($data->status == 0)
                                <span class="badge badge--warning">@lang('Pending')</span>
                                @elseif($data->status == 1)
                                <span class="badge badge--success">@lang('Approved')</span>
                                @else
                                <span class="badge badge--danger">@lang('Rejected')</span>
                                @endif
                            </div>
                        </div>
                        <div class="job__footer">
                            <a href="{{ route('user.job.detail.attachment',$data->id) }}" class="cmn--btn btn--sm">@lang('Detail')</a>
                            <p class="take-on">@lang('Project take on')</p>
                            <p class="take-on-date">{{ $data->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="finished__job__item">
            <div class="row w-100 justify-content-between g-0 gy-3">
                <h3 class="text--base text-center">{{ __($emptyMessage) }}</h3>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
