@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard__content contact__form__wrapper">
    <table class="table transection__table job__history">
        <thead>
            <tr>
                <th>@lang('Job Code')</th>
                <th>@lang('Quantity')</th>
                <th>@lang('Rate')</th>
                <th>@lang('Total')</th>
                <th>@lang('Status')</th>
                <th>@lang('Date')</th>
                <th>@lang('More')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jobs as $k => $data)
                <tr>
                    <td data-label="#@lang('Job Code')">
                        <span class="invoice-id">{{ __($data->job_code) }}</span>
                    </td>
                    <td data-label="@lang('Quantity')">
                        <span class="workers">{{ $data->quantity }} </span>
                    </td>
                    <td data-label="@lang('Rate')">
                        <span class="amount">
                            {{ __($general->cur_sym) }}{{ showAmount($data->rate) }}
                        </span>
                    </td>
                    <td data-label="@lang('Total')">
                        <span class="amount">
                            {{ __($general->cur_sym) }}{{ showAmount($data->total) }}
                        </span>
                    </td>
                    <td data-label="@lang('Status')">
                        @if ($data->status == 0)
                            <span class="badge badge--warning">@lang('Pending')</span>
                        @elseif($data->status == 1)
                            <span class="badge badge--primary">@lang('Approved')</span>
                        @elseif($data->status == 2)
                            <span class="badge badge--success">@lang('Completed')</span>
                        @elseif($data->status == 3)
                            <span class="badge badge--dark">@lang('Paused')</span>
                        @else
                            <span class="badge badge--danger">@lang('Rejected')</span>
                        @endif
                    </td>
                    <td data-label="@lang('Time')">
                        <span class="time">{{ showDateTime($data->created_at) }}<br>{{ diffForHumans($data->created_at) }}</span>
                    </td>
                    <td data-label="@lang('Details')">
                        <div class="d-flex flex-wrap table-icon">
                        
                            <a href="{{ route('user.job.edit',$data->id) }}" class="text--base me-2" data-toggle="tooltip" title="Edit">
                                <i class="lar la-edit"></i>
                            </a>
                            @if ($data->status == 1)
                            <a href="{{ route('user.job.status', [$data->id,$data->status]) }}" class="text--base statusBtn me-2" data-toggle="tooltip" title="Approve">
                                <i class="las la-toggle-on"></i>
                            </a>
                            @elseif($data->status == 3 || $data->status == 0)
                            <a href="{{ route('user.job.status', [$data->id,$data->status]) }}" class="text--base statusBtn me-2" data-toggle="tooltip" title="{{ $data->status == 3?'Paused':'Pending' }}">
                                <i class="las la-toggle-off"></i>
                            </a>
                            @else
                            @endif
                            <a href="{{ route('user.job.detail',$data->id) }}" class="text--base notification-holder" data-toggle="tooltip" title="Detail">
                                <i class="las la-desktop"></i>
                                <span class="notification-count">{{ count($data->proofNotification) }}</span>
                            </a>
                            
                        </div>
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
{{ $jobs->links() }}
{{-- <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('Are you sure change job status')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="create__campaigns__form" action="{{ route('user.job.status') }}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="country" class="form--label">@lang('Job Status')
                        <span class="text--danger">*</span>
                    </label>
                    <select class="form-control" name="status" id="status">
                        
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--md btn-danger" data-bs-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn--md btn btn--base">@lang('Submit')</button>
            </div>
        </form>
      </div>
    </div>
</div> --}}
@endsection
@push('style')
<style>
    .form-control:focus{
        box-shadow: none;
    }
</style>
    
@endpush
@push('script')
<script>
    $('.statusBtn').on('click', function() {
        $("#status").html("");
        var modal = $('#statusModal');
        modal.find('input[name=id]').val($(this).data('id'));
        var status = $(this).data('status');
        console.log(status);
        // $("#status").prepend(`<option value="" selected disabled>Select One</option>`);
        if(status == 0 || status == 1){
            $("#status").append(`<option value="3">@lang('Paused')</option>`);
        }
        else if(status == 3){
            $("#status").append(`<option value="0">@lang('Continue')</option>`);
        }
        else{
            $("#status").html("");
        }

        

    });
</script>
@endpush
