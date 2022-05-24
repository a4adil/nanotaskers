@php
    $data = getContent('top_freelancer.content',true);
    $topFreelancer = \App\Models\JobProve::where('status', 1)->groupBy('user_id')->selectRaw('count(status) as count, user_id')->with('user')->orderBy('count', 'desc')->take(5)->get();
@endphp
<section class="freelancer-section padding-top padding-bottom overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section__header text-center">
                    <h2 class="section__header-title">{{ __($data->data_values->heading) }}</h2>
                    <p>{{ __($data->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="freelancer__slider">

            @forelse ($topFreelancer as $freelancer)
            <div class="single-slide">
                <div class="freelancer__item">
                    <div class="freelancer__header">
                        <div class="thumb">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $freelancer->user->image) }}" alt="freelancer">
                            <span class="verify-status verified"><i class="las la-check"></i>
                            <span class="tooltip">@lang('Verified Freelancer')</span></span>
                        </div>
                        <h5 class="name">{{ $freelancer->user->fullname }}</h5>
                        <p class="designation">{{ $freelancer->user->email }}</p>
                    </div>
                    <div class="freelancer__footer">
                        <ul class="freelancer__info d-flex justify-content-center">
                            <li>
                                <h6 class="title">@lang('Country')</h6>
                                <span>{{ $freelancer->user->address->country }}</span>
                            </li>
                            <li class="text-center">
                                <h6 class="title">@lang('Jobs Completed')</h6>
                                <span>({{ $freelancer->count }})</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            @empty

            @endforelse

        </div>
    </div>
</section>
