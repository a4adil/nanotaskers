@extends($activeTemplate.'layouts.frontend')

@section('content')
    @php
        $contact = getContent('contact_us.content',true);
        $contacts = getContent('contact_us.element',false,null,true);
    @endphp
    <section class="contact-section padding-top padding-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="contact__info__wrapper">
                        <h3 class="contact__info__wrapper-title">{{ __($contact->data_values->title) }}</h3>
                        <p>{{ __($contact->data_values->short_details) }}</p>
                        @foreach ($contacts as $item)                   
                        <h4 class="title">@php echo $item->data_values->icon @endphp {{ __($item->data_values->title) }}</h4>
                        <ul class="contacts"> 
                            <li>{{ __($item->data_values->content) }}</li>
                        </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact__form__wrapper">
                        <h3 class="contact__form__wrapper-title">@lang("Let's Talk")</h3>
                        <form class="contact__form" method="post" action="">
                            @csrf
                            <div class="form--group">
                                <label class="form-label" for="name">@lang('Name')<span
                                        class="text--danger">*</span></label>
                                <input name="name" id="name" type="text"
                                    class="form--control" value="{{ auth()->user() ? auth()->user()->fullname : old('name') }}" @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class=" form--group">
                                <label class="form-label" for="email">@lang('Email') <span
                                        class="text--danger">*</span></label>
                                <input name="email" id="email" type="text"
                                    class="form--control" value="{{ auth()->user() ? auth()->user()->email : old('email') }}" @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class="form--group">
                                <label class="form-label" for="subject">@lang('Subject')<span
                                        class="text--danger">*</span></label>
                                <input name="subject" id="subject" type="text" class="form--control" value="{{ old('subject') }}" required>
                            </div>
                            <div class="form--group">
                                <label class="form-label" for="msg">@lang('Message')<span
                                        class="text--danger">*</span></label>
                                <textarea id="msg" name="message" class="form--control"></textarea>
                            </div>
                            <button class="btn btn--base w-100 radius-5" type="submit">@lang('Submit Message')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
