@extends('admin.layouts.app')
@section('panel')

    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Submit Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Balance')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($job->proof as $data)
                            <tr>
                                <td data-label="@lang('User')">
                                    <span class="font-weight-bold">{{$data->user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $data->user->id) }}"><span>@</span>{{ $data->user->username }}</a>
                                    </span>
                                </td>


                                <td data-label="@lang('Email-Phone')">
                                    {{ $data->user->email }}<br>{{ $data->user->mobile }}
                                </td>
                                <td data-label="@lang('Country')">
                                    <span class="font-weight-bold" data-toggle="tooltip" data-original-title="{{ $data->user->address->country }}">{{ $data->user->address->country }}</span>
                                </td>

                                <td data-label="@lang('Job Submit')">
                                    {{ showDateTime($data->created_at) }} <br> {{ diffForHumans( $data->created_at) }}
                                </td>
                                <td data-label="@lang('Status')">
                                    @if ($data->status == 0)
                                        <span class="text--small badge font-weight-normal badge--warning">
                                            @lang('Pending')
                                        </span>
                                    @else
                                        <span class="text--small badge font-weight-normal badge--success">
                                            @lang('Approved')
                                        </span>
                                    @endif
                                </td>

                                <td data-label="@lang('Balance')">
                                    <span class="font-weight-bold">
                                    {{ $general->cur_sym }}{{ showAmount($job->rate) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
