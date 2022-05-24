@extends($activeTemplate.'layouts.master')

@section('content')
<div class="contact__form__wrapper">
    <h4 class="text-center mb-3">@lang('Current Balance') :
        <strong>{{ showAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</strong>
    </h4>
    <div class="deposit-preview mb-4">
        <div class="deposit-thumb">
            <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $withdraw->method->image,imagePath()['withdraw']['method']['size'])}}" alt="@lang('Image')">
        </div>
        <div class="deposit-content">
            <ul>
                <li>
                    @lang('Request Amount:') <span class="text--success">{{showAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                </li>
                <li>
                    @lang('Withdrawal Charge:') <span class="text--danger">{{showAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                </li>
                <li>
                    @lang('After Charge:') <span
                        class="text--warning">{{showAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                </li>
                <li>
                    @lang('Conversion Rate:') <span class="text--info">1
                        {{ __($general->cur_text) }}
                        @lang('=') {{showAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                </li>
                <li>
                    @lang('You Will Get') : <span
                        class="text--primary">{{showAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                </li>
                <li>
                    @lang('Balance Will be') : <span
                        class="text--primary">{{showAmount($withdraw->user->balance - ($withdraw->amount))}} {{__($general->cur_text)}}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="withdraw-form">
        <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if($withdraw->method->user_data)
                @foreach($withdraw->method->user_data as $k => $v)
                    @if($v->type == "text")
                        <div class="form-group mb-2">
                            <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger mb-1">*</span>  @endif</strong></label>
                            <input type="text" name="{{$k}}" class="form-control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                            @if ($errors->has($k))
                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                            @endif
                        </div>
                    @elseif($v->type == "textarea")
                        <div class="form-group">
                            <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger mb-1">*</span>  @endif</strong></label>
                            <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                            @if ($errors->has($k))
                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                            @endif
                        </div>
                    @elseif($v->type == "file")
                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger mb-1">*</span>  @endif</strong></label>
                        <div class="form-group">
                            <input class="form-control form--control" id="scrnshort" type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif onchange="previewFile(this);">
                        
                            @if ($errors->has($k))
                                <br>
                                <span class="text-danger">{{ __($errors->first($k)) }}</span>
                            @endif
                        </>
                    @endif
                @endforeach
            @endif
            @if(auth()->user()->ts)
                <div class="form-group">
                    <label>@lang('Google Authenticator Code')</label>
                    <input type="text" name="authenticator_code" class="form-control" required>
                </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn--base w-100 mt-3 btn--md">@lang('Confirm')</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')
    <script>
        function previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
