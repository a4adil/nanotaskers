@extends($activeTemplate.'layouts.master')

@section('content')
<div class="dashboard__content contact__form__wrapper">
    <div class="wrapper d-flex flex-wrap justify-content-between align-items-center pb-4">
        <h4 class="">@lang('Ticket History')</h4>
    </div>
    <table class="table transection__table">
        <thead>
            <tr>
                <th>@lang('Subject')</th>
                <th>@lang('Status')</th>
                <th>@lang('Priority')</th>
                <th>@lang('Last Reply')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supports as $key => $support)
                <tr>
                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                    <td data-label="@lang('Status')">
                        @if($support->status == 0)
                            <span class="status completed">@lang('Open')</span>
                        @elseif($support->status == 1)
                            <span class="status approved">@lang('Answered')</span>
                        @elseif($support->status == 2)
                            <span class="status pending">@lang('Customer Reply')</span>
                        @elseif($support->status == 3)
                            <span class="status paused">@lang('Closed')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Priority')">
                        @if($support->priority == 1)
                            <span class="status text--dark">@lang('Low')</span>
                        @elseif($support->priority == 2)
                            <span class="status text--success">@lang('Medium')</span>
                        @elseif($support->priority == 3)
                            <span class="status text--primary">@lang('High')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                    <td data-label="@lang('Action')">
                        <a href="{{ route('ticket.view', $support->ticket) }}" class="text--danger">
                            <i class="las la-inbox fs-4"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{$supports->links()}}

@endsection
