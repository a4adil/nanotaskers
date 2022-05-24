@php
$captcha = loadCustomCaptcha();
@endphp
@if ($captcha)
    <div class="form--group">
        <div class="col-md-12">
            @php echo $captcha @endphp
        </div>
    </div>
    <div class="form--group">
        <label class="form-label">@lang('Enter Code') <span class="text--danger">*</span></label>
        <input type="text" name="captcha" class="form--control" required>
    </div>
@endif
