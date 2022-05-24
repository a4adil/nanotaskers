@extends($activeTemplate.'layouts.master')
@section('content')

<div class="two__factor card custom--card primary-bg">
    <div class="card-body border-radius-0 p-4">
        <div class="card-wrapper my-2"></div>
        <form action="{{ route('user.deposit.manual.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-center mt-2">@lang('You have requested') <b
                            class="text-success">{{ showAmount($data['amount']) }}
                            {{ __($general->cur_text) }}</b> , @lang('Please pay')
                        <b class="text-success">{{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }}
                        </b> @lang('for successful payment')
                    </p>
                    <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                    <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                </div>
                @if ($method->gateway_parameter)
                    @foreach (json_decode($method->gateway_parameter) as $k => $v)
                        @if ($v->type == 'text')
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label>
                                        <strong>{{ __(inputTitle($v->field_level)) }}
                                            @if ($v->validation == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                        </strong>
                                    </label>
                                    <input type="text" class="form-control form--control"
                                        name="{{ $k }}" value="{{ old($k) }}"
                                        placeholder="{{ __($v->field_level) }}">
                                </div>
                            </div>
                        @elseif($v->type == 'textarea')
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label><strong>{{ __(inputTitle($v->field_level)) }}
                                            @if ($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                    <textarea name="{{ $k }}" class="form-control"
                                        placeholder="{{ __($v->field_level) }}"
                                        rows="3">{{ old($k) }}</textarea>
                                </div>
                            </div>
                        @elseif($v->type == 'file')
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label>
                                        <strong>
                                            {{ __($v->field_level) }}
                                            @if ($v->validation == 'required') <span class="text-danger">*</span>  @endif
                                        </strong>
                                    </label>
                                    <br>
                                    <div class="fileinput fileinput-new " data-provides="fileinput">
                                        <input type="file" class="form-control form--control" name="{{ $k }}" accept="image/*" onchange="previewFile(this);">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn--base radius-5 mt-3 w-100">@lang('Pay
                            Now')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

    
