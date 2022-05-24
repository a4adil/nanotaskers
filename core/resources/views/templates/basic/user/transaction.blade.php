@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="dashboard__content contact__form__wrapper">
        <div class="wrapper d-flex flex-wrap justify-content-between align-items-center pb-4">
            <h4 class="">@lang('Transaction History')</h4>
        </div>
        <table class="table transection__table">
            <thead>
                <tr>
                    <th>@lang('Transaction ID')</th>
                    <th>@lang('Payment Type')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Balance')</th>
                    <th>@lang('Time')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allTransaction as $k=>$data)
                <tr>
                    <td data-label="#@lang('Trx')">{{ $data->trx }}</td>
                    <td data-label="@lang('Payment Type')">{{ __($data->details) }}</td>
                    <td data-label="@lang('Amount')">
                        @if ($data->trx_type == '-')
                            <strong class="text--danger">{{ __($data->trx_type) }}&nbsp;{{ $general->cur_sym }}{{ showAmount($data->amount) }}</strong>
                        @else
                            <strong class="text--success">{{ __($data->trx_type) }}&nbsp;{{ $general->cur_sym }}{{ showAmount($data->amount) }}</strong>
                        @endif
                    </td>
                    <td data-label="@lang('Receivable')" class="text-success">
                        <strong>{{ $general->cur_sym }}{{ showAmount($data->post_balance) }}</strong>
                    </td>

                    <td data-label="@lang('Time')">
                        {{ showDateTime($data->created_at) }} <br>
                        {{ diffForHumans($data->created_at) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="justify-content-center text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
