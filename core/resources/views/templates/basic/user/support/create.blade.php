@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ticket__wrapper">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="ticket__wrapper-title mb-4 me-3 text-dark">@lang('Create Tickets')</h4>
    </div>
    <div class="message__chatbox__body">
        <form class="job__finished__form row" action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
            @csrf
            <div class="form--group col-sm-6 mb-2">
                <label for="name" class="form--label-2">@lang('Your Name')</label>
                <input type="text" id="name" class="form-control form--control" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}">
            </div>
            <div class="form--group col-sm-6 mb-2">
                <label for="email" class="form--label-2">@lang('Your Email')</label>
                <input type="text" id="email" class="form-control form--control" name="email" value="{{@$user->email}}">
            </div>

            <div class="form--group col-sm-12 mb-2">
                <label for="subject" class="form--label-2">@lang('Your Subject')</label>
                <input type="text" id="subject" class="form-control form--control" placeholder="Subject" name="subject" value="{{old('subject')}}">
            </div>
            
            <div class="form--group col-sm-12 mb-2">
                <label for="email" class="form--label-2">@lang('Priority')</label>
                <select name="priority" class="form-control form--control nice-select w-100" name="type">
                    <option value="" selected disabled>@lang('Select One')</option>
                    <option value="3">@lang('High')</option>
                    <option value="2">@lang('Medium')</option>
                    <option value="1">@lang('Low')</option>
                </select>
            </div>

            
            <div class="form--group col-sm-12 mb-2">
                <label for="message" class="form--label-2">@lang('Your Message')</label>
                <textarea id="message" name="message"  class="form-control form--control">{{old('message')}}</textarea>
            </div>
            <div class="form--group col-sm-12">
                <div class="d-flex">
                    <div class="left-group col p-0">
                        <label for="inputAttachments" class="form--label-2">@lang('Attachments')</label>
                        <input type="file" class="form-control form--control w-100" name="attachments[]" id="inputAttachments">
                        <span class="info fs--14">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span>
                    </div>
                    <div class="add-area">
                        <label class="form--label-2 d-block">&nbsp;</label>
                        <button class="cmn--btn btn--sm bg--primary ms-2 ms-md-4 form--control addFile" type="button"><i class="las la-plus"></i></button>
                    </div>
                </div>
                <div id="fileUploadsContainer"></div>
            </div>
            <div class="form--group col-sm-12 mb-0 mt-3">
                <button type="submit" class="btn btn--base w-100 mt-3 btn--md">@lang('Create Ticket')</button>
            </div>
        </form> 
    </div>
</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="form--group col-sm-12">
                        <div class="d-flex">
                            <div class="left-group col p-0">
                                <label for="inputAttachments" class="form--label-2">@lang('Attachments')</label>
                                <input type="file" class="form-control form--control w-100" name="attachments[]" id="inputAttachments">
                                <span class="info fs--14">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span>
                            </div>
                            <div class="add-area">
                                <label class="form--label-2 d-block">&nbsp;</label>
                                <button class="btn--sm bg--danger text-light ms-2 ms-md-4 form--control remove-btn" type="button"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.form--group').remove();
            });
        })(jQuery);
    </script>
@endpush
