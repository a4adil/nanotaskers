@php
    $generalFaq = getContent('faq.element', false, null, false);
@endphp
@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="faq-section padding-top padding-bottom">
    <div class="container">
        <div class="faq__wrapper">
            
            <div class="tab-content mt-4 ">
                <div class="tab-pane show fade active" id="general">
                    @foreach ($generalFaq as $data)
                        <div class="faq__item">
                            <div class="faq__item-title">
                                <h4 class="title">{{ __($data->data_values->question) }}</h4>
                            </div>
                            <div class="faq__item-content">
                                <p>@php echo $data->data_values->answer @endphp</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
