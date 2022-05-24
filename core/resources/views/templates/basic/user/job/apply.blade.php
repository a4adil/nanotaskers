@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard__content contact__form__wrapper">
    <table class="table transection__table job__history">
        <thead>
            <tr>
                <th>@lang('Job Code')</th>
                <th>@lang('Posted By')</th>
                <th>@lang('Rate')</th>
                <th>@lang('Status')</th>
                <th>@lang('Date')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jobs as $k => $data)
                <tr>
                    <td data-label="#@lang('Job Code')">
                        <span class="invoice-id">{{ __($data->job->job_code) }}</span>
                    </td>
                    <td data-label="@lang('Posted By')">
                        <span class="workers">{{ $data->job->user->username }} </span>
                    </td>
                    <td data-label="@lang('Rate')">
                        <span class="amount">
                            {{ __($general->cur_sym) }}{{ showAmount($data->job->rate) }}
                        </span>
                    </td>
                    <td data-label="@lang('Status')">
                        @if ($data->status == 0)
                        <span class="badge badge--warning">@lang('Pending')</span>
                        @elseif($data->status == 1)
                        <span class="badge badge--success">@lang('Approved')</span>
                        @else
                        <span class="badge badge--danger">@lang('Rejected')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Time')">
                        <span class="time">{{ showDateTime($data->created_at) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $jobs->links() }}

@endsection
