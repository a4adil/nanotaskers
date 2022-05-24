@extends($activeTemplate.'layouts.master')

@section('content')
<div class="ticket__wrapper">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h6 class="text--white me-2">
            @if($my_ticket->status == 0)
                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
            @elseif($my_ticket->status == 1)
                <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
            @elseif($my_ticket->status == 2)
                <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
            @elseif($my_ticket->status == 3)
                <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
            @endif
            <span class="text-dark mt-2 mt-sm-0">[@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span>
        </h6>
        <button class="btn btn--sm btn--danger" type="button" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="las la-times"></i></button>
    </div>
    <div class="message__chatbox__body">
        @if($my_ticket->status != 4)
        <form class="job__finished__form row" method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="replayTicket" value="1">
            <div class="form--group col-sm-12">
                <label for="message" class="form--label-2">@lang('Your Reply')</label>
                <textarea id="message" name="message" class="form-control form--control-3"  placeholder="@lang('Your Reply')"  rows="4" cols="10"></textarea>
            </div>
            <div class="form--group col-sm-12">
                <div class="d-flex">
                    <div class="left-group col p-0">
                        <label for="inputAttachments" class="form--label-2">@lang('Attachments')</label>
                        <input type="file" class="form-control form--control w-100" name="attachments[]" id="inputAttachments">
                        <span class="info fs-small">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span>
                    </div>
                    <div class="add-area">
                        <label class="form--label-2 d-block">&nbsp;</label>
                        <button class="cmn--btn btn--sm bg--primary ms-2 ms-md-4 addFile" type="button"><i class="las la-plus"></i></button>
                    </div>
                </div>
                <div id="fileUploadsContainer"></div>
                <div class="mt-2">
                    <span class="info fs-small">@lang('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span>
                </div>
            </div>
            <div class="form--group col-sm-12 mb-0">
                <button type="submit" class="btn btn--base w-100 mt-3 btn--md">@lang('Reply')</button>
            </div>
        </form>
        @endif
    </div>
</div>
<div class="ticket__wrapper mt-2">
    <div class="message__chatbox__body">
        <ul class="reply-message-area">
            @forelse($messages as $message)
                @if ($message->admin_id == 0)
                    <li>
                        <div class="reply-item">
                            <div class="name-area">
                                <div class="reply-thumb">
                                    <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['size']) }}"
                                        alt="user">
                                </div>
                                <h6 class="title">{{ $message->ticket->name }}</h6>
                            </div>
                            <div class="content-area">
                                <span class="meta-date">
                                    @lang('Posted on') <span
                                        class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                </span>
                                <p>
                                    {{ $message->message }}
                                </p>
                                @if ($message->attachments()->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                class="mr-3"><i class="las la-file"></i>
                                                @lang('Attachment') {{ ++$k }} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="reply-item">
                            <div class="name-area">
                                <div class="reply-thumb">
                                    <img src="{{ getImage(imagePath()['profile']['admin']['path'] . '/' . $message->admin->image, imagePath()['profile']['admin']['size']) }}"
                                        alt="user">
                                </div>
                                <h6 class="title">{{ $message->admin->name }}</h6>
                            </div>
                            <div class="content-area">
                                <span class="meta-date">
                                    @lang('Posted on') <span
                                        class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                </span>
                                <p>
                                    {{ $message->message }}
                                </p>
                                @if ($message->attachments()->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                class="mr-3"><i class="las la-file"></i>
                                                @lang('Attachment') {{ ++$k }} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endif
            @empty
                <li>
                    {{ __($emptyMessage) }}
                </li>
            @endforelse
        </ul>
    </div>
</div>


<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf
                <input type="hidden" name="replayTicket" value="2">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation')!</h5>
                    <button type="button" class="btn btn--sm bg--danger text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <strong class="text-dark">@lang('Are you sure you want to close this support ticket')?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--sm btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success btn--sm">@lang("Confirm")</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="form--group col-sm-12 mt-2">
                        <div class="d-flex">
                            <div class="left-group col p-0">
                                <input type="file" class="form-control form--control w-100" name="attachments[]" id="inputAttachments">
                            </div>
                            <div class="add-area">
                                <button class="btn--sm bg--danger text-light ms-2 ms-md-4 form--control remove-btn" type="button"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.form--group').remove();
            });
        })(jQuery);

    </script>
@endpush
