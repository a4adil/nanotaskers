@extends($activeTemplate.'layouts.master')
<link rel="stylesheet"  href="{{ asset($activeTemplateTrue . 'css/styleu.css') }}">
@push('style')
    <style>
        .payment-method-item .payment-method-header {
            display: flex;
            flex-wrap: wrap;
        }
        .payment-method-item .payment-method-header .thumb {
            width: 220px;
            position: relative;
            margin-bottom: 30px;
        }
        .payment-method-item .payment-method-header .thumb .profilePicPreview {
            width: 210px;
            height: 210px;
            display: block;
            border: 3px solid #f1f1f1;
            box-shadow: 0 0 5px 0 rgb(0 0 0 / 25%);
            border-radius: 10px;
            background-size: cover;
            background-position: center;
        }
        .payment-method-item .payment-method-header .thumb .avatar-edit {
            position: absolute;
            bottom: -15px;
            right: 0;
        }
        .payment-method-item .payment-method-header .thumb .profilePicUpload {
            font-size: 0;
            opacity: 0;
            width: 0;
        }

        .payment-method-item .payment-method-header .thumb .avatar-edit label {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            border: 2px solid #fff;
            font-size: 18px;
            cursor: pointer;
        }
        .form-control:disabled, .form-control[readonly]{
            background-color: #fff;
        }
        
        div.nicEdit-main
        {
            min-height: 420px !important;
        }
    </style>
@endpush
@section('content')

<!--<div class="dashboard__content">-->
<!--    <div class="campaigns__wrapper">-->
<!--        <div class="create__campaigns">-->
<!--            <form class="create__campaigns__form" action="{{ route('user.job.update',$job->id) }}" method="POST" enctype="multipart/form-data">  -->
<!--                @csrf-->
<!--                <div class="row">-->
<!--                    <div class="col-xl-4 col-lg-5 col-md-5">-->
<!--                        <div class="payment-method-item">-->
<!--                            <div class="payment-method-header">-->
<!--                                <div class="thumb">-->
<!--                                    <div class="avatar-preview">-->
<!--                                        <div class="profilePicPreview w-100" id="previewImg"-->
<!--                                            style="background-image: url({{ getImage(imagePath()['job']['attachment']['path'] . '/' . $job->attachment, imagePath()['job']['attachment']['size']) }})">-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="avatar-edit">-->
<!--                                        <input type="file" name="attachment" class="profilePicUpload" id="image"-->
<!--                                            accept=".png, .jpg, .jpeg" onchange="previewFile(this);"/>-->
<!--                                        <label for="image" class="bg--base"><i class="la la-pencil text-light"></i></label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-xl-8 col-lg-7 col-md-7">-->
<!--                        <div class="form-group mb-3">-->
<!--                            <label for="country" class="form--label">@lang('Category')-->
<!--                                <span class="text--danger">*</span>-->
<!--                            </label>-->
<!--                            <select class="form-control form--control h-50 w-100" name="category_id" id="category">-->
<!--                                <option value="" selected disabled>@lang('Select One')</option>-->
<!--                                @foreach ($categories as $category)-->
<!--                                    <option value="{{ $category->id }}" {{ $job->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>-->
<!--                                @endforeach-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="country" class="form--label">@lang('Subcategory')</label>-->
<!--                            <select class="form-control form--control h-50 w-100" name="subcategory_id" id="subcategory">-->

<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row my-3">-->
<!--                    <div class="col-xl-12">-->
<!--                        <div class="form-group mb-3">-->
<!--                            <label for="country" class="form--label">@lang('Job Proof')-->
<!--                                <span class="text--danger">*</span>-->
<!--                            </label>-->
<!--                            <select class="form-control form--control h-50 w-100" name="job_proof" id="fileOption">-->
<!--                                <option value="" selected disabled>@lang('Select Job Proof')</option>-->
<!--                                <option value="1" {{ $job->job_proof == 1 ? 'selected' : '' }}>@lang("Optional")</option>-->
<!--                                <option value="2" {{ $job->job_proof == 2 ? 'selected' : '' }}>@lang("Required")</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                
<!--                <div class="row" id="choiceOption">-->
<!--                    <label for="country" class="form--label">@lang('Select File Upload Option')-->
<!--                        <span class="text--danger">*</span>-->
<!--                    </label>-->
<!--                    <div class="input-group">-->
<!--                        @foreach ($files as $file)-->
<!--                            <div class="form-check form-check-inline">-->
<!--                                <input class="form-check-input" type="checkbox" name="file_name[]" id="inlineRadio{{ $file->id }}" value="{{ __($file->name) }}">-->
<!--                                <label class="form-check-label" for="inlineRadio{{ $file->id }}">{{ __($file->name) }}</label>-->
<!--                            </div>-->
<!--                        @endforeach-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="row">-->
<!--                    <div class="col-xl-4">-->
<!--                        <label for="workers" class="form--label">@lang('Quantity')-->
<!--                            <span class="text--danger">*</span>-->
<!--                        </label>-->
<!--                        <div class="input-group">-->
<!--                            <input type="number" id="workers" name="quantity" class="form-control form--control workers"  min="1" value="{{ $job->quantity }}" {{ $job->status == 1 ? 'readonly':'' }}>-->
<!--                        </div>-->
<!--                    </div>-->
                    
<!--                    <div class="col-xl-4">-->
<!--                        <label for="country" class="form--label">@lang('Worker will earn')-->
<!--                            <span class="text--danger">*</span>-->
<!--                        </label>-->
<!--                        <div class="input-group">-->
<!--                            <input type="number" step="any" name="rate" class="form-control form--control rate" min="0" value="{{ showAmount($job->rate) }}" {{ $job->status == 1 ? 'readonly':'' }}>-->
<!--                            <div class="input-group-apend ">-->
<!--                                <div class="input-group-text h-50 radius-5 px-3">{{ $general->cur_sym }}</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-xl-4">-->
<!--                        <label for="country" class="form--label">@lang('Total Budget')</label>-->
<!--                        <div class="input-group">-->
<!--                            <input type="text" name="total_budget" class="form-control form--control total" value="{{ showAmount($job->total) }}" readonly>-->
<!--                            <div class="input-group-apend ">-->
<!--                                <div class="input-group-text h-50 radius-5 px-3">{{ $general->cur_sym }}</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <label for="country" class="form--label">@lang('Job Title')-->
<!--                    <span class="text--danger">*</span>-->
<!--                </label>-->
<!--                <div class="input-group">-->
<!--                    <input type="text" name="title" class="form-control form--control" value="{{ $job->title }}">-->
<!--                </div>-->
<!--                <label for="country" class="form--label">@lang('Job Description')-->
<!--                    <span class="text--danger">*</span>-->
<!--                </label>-->
<!--                <div class="input-group">-->
<!--                    <textarea class="form-control form--control nicEdit" name="description">{{ $job->description }}</textarea>-->
<!--                </div>-->
<!--                <button class="cmn--btn btn--md w-100" type="submit">@lang('Submit')</button>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<div class="wrapper mb-wrapper">
            <form class="create__campaigns__form" action="{{ route('user.job.update',$job->id) }}" id="wizard" method="POST" enctype="multipart/form-data">
                @csrf
        		<!-- SECTION 1 -->
                <h4></h4>
                <section>
                    <h3>Choose targeting zone</h3>
                	<div class="row">

                            @php 
                                $b = 1;
                            @endphp
                            @foreach ($continents as $conti)
                            <div class="col-md-2">
                              <input type="radio" class="btn-check" name="continent" value="{{ $conti->code }}" id="{{ $conti->code }}" {{ $conti->code == $job->continent ? "checked" : "" }} />
                              <label style="font-size: 12px;" class="mb-btn-check btn btn-outline-light border-1 border text-dark btn-sm small" data-id="{{ $conti->code }}" for="{{ $conti->code }}">{{ $conti->name }}</label>
                            </div>
                            @php 
                                $b++;
                            @endphp
                            @endforeach
                         
                        
                	</div>
                    
                    <div class="row mb-countries">
                        <h3 class="mb-h3">Select ALL countries you want to INCLUDE from the selected zone (optional)</h3>
                            @foreach ($countries as $con)
                            @foreach ($ContinentCountries as $country)
                              <div class="col-md-2">
                                <input type="checkbox" class="btn-check" id="{{$con->country_id}}" value="{{$con->code}}" name="country[]" autocomplete="off"  {{ $con->code == $country->country ? "checked" : "" }} />
                                <label style="font-size: 12px;" class="btn btn-outline-success border-1 border  btn-sm small" for="{{$con->country_id}}">{{$con->name}}</label>
                                </div>
                            @endforeach
                            @endforeach
                        
                        
                    </div>
                </section>

                <h4></h4>
                <section>
                    <h3>Cetegory</h3>
                	<div class="row">
                        
                            @php 
                                $b = 1;
                            @endphp
                            @foreach ($categories as $category)
                            <div class="col-md-2">
                              <input type="radio" class="btn-check" name="category_id" value="{{ $category->id }}" id="c{{ $category->id }}" {{ $category->id == $job->category_id ? "checked" : "" }} />
                              <label style="font-size: 12px;" class="mb-btn-check1 btn btn-outline-light border-1 border text-dark btn-sm small" data-id="{{ $category->id }}" for="c{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                            @php 
                                $b++;
                            @endphp
                            @endforeach
                         
                        
                	</div>
                	
                	<div class="row mb-subcategories">
                        <h3 class="mb-cat-h3">Sub Category</h3>
                            @foreach ($subcategories as $subCat)
                              <div class="col-md-2">
                                <input type="radio" class="btn-check subcategory" id="sc{{$subCat->id}}" {{ $subCat->id == $job->subcategory_id ? "checked" : "" }} value="{{$subCat->id}}" name="subcategory" autocomplete="off" />
                                <label style="font-size: 12px;" class="btn btn-outline-success border-1 border  btn-sm small" for="sc{{$subCat->id}}">{{$subCat->name}}</label>
                                </div>
                            @endforeach
                        
                        
                    </div>
                    
                </section>

				<!-- SECTION 2 -->
                <h4></h4>
                <section>
                	<h3>Proofs</h3>
                	<div class="row">
                	    <div class="col-md-12">
                        
                            <label for="country" class="form--label">@lang('Job Title')
                                <span class="text--danger">*</span>
                            </label><br>
                            <div class="input-group">
                                <input type="text" name="title" class="form-control form--control" value="{{ $job->title }}">
                            </div>
                        </div>
                	</div>
                	
                	<div class="row">
                	    <div class="col-md-12">
                        
                            <label for="country" class="form--label">@lang('Job Description')
                                <span class="text--danger">*</span>
                            </label>

                                @php
                                    if(!empty(($job->description))){
                                        $description = json_decode($job->description, true);
                                        if(is_array($description)){
                                        
                                            foreach ($description as $value) {
                                                $ul = '<div id="inputFormRow">
                                                        <div class="input-group mb-3">';
                                                $ul .= '<input value="'.(string)$value.'" type="text" style="max-width: 85%" name="description[]" class="form-control m-input" autocomplete="off">';
                                                $ul .= ' <div class="input-group-append">
                                                                <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                                            </div>
                                                        </div>';
                                                echo $ul;
                                            }
                                        }
                                    }
                                    
                                @endphp

                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="text" style="max-width: 85%" name="description[]" class="form-control m-input" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                </div>
                            </div>
                
                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">Add Row</button>
                        </div>
                	</div>
                	
                	<!--<h3>What specific tasks need to be completed</h3>-->
                	<!--<div class="row">-->
                	<!--    @php $b = 1; @endphp-->
                	<!--    @foreach ($PostsSteps as $step)-->
                	<!--    <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Step '){{$b}}-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="step[]" class="form-control form--control" value="{{ $step->step }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                 <!--       @php $b++; @endphp-->
                 <!--       @endforeach-->
                        
                	<!--</div>-->
                	
                	<!--<h3>Variables Values. Max 1000 lines. (optional step: only required if job steps contain variables) </h3>-->
                	<!--<div class="row">-->
                	<!--    <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Description')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="description" class="form-control form--control" value="{{ old('description') }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                 <!--       <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Additional Notes (optional)')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="additional_note" class="form-control form--control" value="{{ old('additional_note') }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                	<!--</div>-->
                	
                	<h3>Required proof the job was completed </h3>
                	<div class="row">
                	    <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Step 1')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="text" name="step1_proof" class="form-control form--control" value="{{ $job->step1_proof  }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Job Proof')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="job_proof1" id="fileOption">
                                <option value="" selected disabled>@lang('Select Type')</option>
                                <option value="1" @if ($job->job_proof1 == 1) selected="selected" @endif>@lang("Optional")</option>
                                <option value="2" @if ($job->job_proof1 == 2) selected="selected" @endif>@lang("Required")</option>
                            </select>
                        </div>
                        
                	</div>
                	
                	<div class="row">
                	    <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Step 2')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="text" name="step2_proof" class="form-control form--control" value="{{ $job->step2_proof }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Job Proof')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="job_proof2" id="fileOption">
                                <option value="" selected disabled>@lang('Select Type')</option>
                                <option value="1" @if ($job->job_proof2 == 1) selected="selected" @endif>@lang("Optional")</option>
                                <option value="2" @if ($job->job_proof2 == 2) selected="selected" @endif>@lang("Required")</option>
                            </select>
                        </div>
                        
                	</div>
                	
                	<div class="row">
                	    <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Step 3')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="text" name="step3_proof" class="form-control form--control" value="{{ $job->step3_proof }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Job Proof')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="job_proof3" id="fileOption">
                                <option value="" selected disabled>@lang('Select Type')</option>
                                <option value="1" @if ($job->job_proof3 == 1) selected="selected" @endif>@lang("Optional")</option>
                                <option value="2" @if ($job->job_proof3 == 2) selected="selected" @endif>@lang("Required")</option>
                            </select>
                        </div>
                        
                	</div>
                	
                	<div class="row">
                	    <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Step 4')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="text" name="step4_proof" class="form-control form--control" value="{{ $job->step4_proof }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Job Proof')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="job_proof4" id="fileOption">
                                <option value="" selected disabled>@lang('Select Type')</option>
                                <option value="1" @if ($job->job_proof4 == 1) selected="selected" @endif>@lang("Optional")</option>
                                <option value="2" @if ($job->job_proof4 == 2) selected="selected" @endif>@lang("Required")</option>
                            </select>
                        </div>
                        
                	</div>
                	
                	<!--<h3>Questions </h3>-->
                	<!--<div class="row">-->
                	<!--    <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Question 1')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="question1" class="form-control form--control" value="{{ $job->question1 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                 <!--       <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Answer 1')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="answer1" class="form-control form--control" value="{{ $job->answer1 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                	<!--</div>-->
                	
                	<!--<div class="row">-->
                	<!--    <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Question 2')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="question2" class="form-control form--control" value="{{ $job->question2 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                 <!--       <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Answer 2')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="answer2" class="form-control form--control" value="{{ $job->answer2 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                	<!--</div>-->
                	
                	
                	<!--<div class="row">-->
                	<!--    <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Question 3')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="question3" class="form-control form--control" value="{{ $job->question3 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                 <!--       <div class="col-md-6">-->
                        
                 <!--           <label for="country" class="form--label">@lang('Answer 3')-->
                 <!--               <span class="text--danger"></span>-->
                 <!--           </label><br>-->
                 <!--           <div class="input-group">-->
                 <!--               <input type="text" name="answer3" class="form-control form--control" value="{{ $job->answer3 }}">-->
                 <!--           </div>-->
                 <!--       </div>-->
                        
                	<!--</div>-->
                	
                	
                	
                    
                </section>

                <!-- SECTION 3 -->
                <h4></h4>
                <section>
                    <h3 style="margin-bottom: 16px;">Job Setting</h3>
                    <div class="row">
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Level')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="level" id="fileOption">
                                
                                <option value="starter" @if ($job->level == 'starter') selected="selected" @endif>@lang("Starter")</option>
                                <option value="advanced" @if ($job->level == 'advanced') selected="selected" @endif>@lang("Advanced")</option>
                                <option value="expert" @if ($job->level == 'expert') selected="selected" @endif>@lang("Expert")</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Speed')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="number" name="speed" class="form-control form--control" value="{{ $job->speed }}">
                            </div>
                        </div>
                        
                        <!--<div class="col-md-6">-->
                        
                        <!--    <label for="country" class="form--label">@lang('Workers Needed')-->
                        <!--        <span class="text--danger"></span>-->
                        <!--    </label><br>-->
                        <!--    <div class="input-group">-->
                        <!--        <input type="number" name="workers_needed" class="form-control form--control" value="{{ old('workers_needed') }}">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <!--<div class="col-md-6">-->
                        
                        <!--    <label for="country" class="form--label">@lang('Max POS/ Worker')-->
                        <!--        <span class="text--danger"></span>-->
                        <!--    </label><br>-->
                        <!--    <div class="input-group">-->
                        <!--        <input type="number" readonly name="max_pos" class="form-control form--control" value="{{ old('max_pos') }}">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Hold job time')
                                <span class="text--danger"></span>
                            </label><br>
                            <div class="input-group">
                                <input type="number" name="hold_job_time" class="form-control form--control" min="3" max="60" value="{{ $job->hold_job_time }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        
                            <label for="country" class="form--label">@lang('Promotion')
                                <span class="text--danger"></span>
                            </label>
                            <select class="form-control form--control h-50 w-100" name="promotion" id="promotion">
                                
                                <option value="no" @if ($job->promotion == 'no') selected="selected" @endif>@lang("No")</option>
                                <option value="yes" @if ($job->promotion == 'yes') selected="selected" @endif>@lang("Yes")</option>
                                
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-6">
                                <label for="workers" class="form--label">@lang('Quantity')
                                    <span class="text--danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" id="quantity" name="quantity" class="form-control form--control workers" min="10" value="{{ $job->quantity }}">
                                </div>
                            </div>
        
                            <div class="col-xl-3">
                                <label for="country" class="form--label">@lang('Worker will earn')
                                    <span class="text--danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" step="any" id="workerwillearn" name="rate" class="form-control form--control rate" min="0" value="{{ $job->rate }}" readonly>
                                    
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <label for="country" class="form--label">@lang('Total Budget')</label>
                                <div class="input-group">
                                    <input type="text" id="total_budget" name="total_budget" class="form-control form--control total" value="{{ $job->total_budget }}" readonly>
                                    
                                </div>
                            </div>
                        </div>
                        <button class="cmn--btn btn--md w-100" type="submit">@lang('Submit')</button>
                        
                    </div>
                </section>

                <!-- SECTION 4 -->
                <!--<h4></h4>-->
                <!--<section>-->
                <!--    <h3>Cart Totals</h3>-->
                <!--    <div class="cart_totals">-->
                <!--        <table cellspacing="0" class="shop_table shop_table_responsive">-->
                <!--            <tr class="cart-subtotal">-->
                <!--                <th>Subtotal</th>-->
                <!--                <td data-title="Subtotal">-->
                <!--                    <span class="woocommerce-Price-amount amount">-->
                <!--                        <span class="woocommerce-Price-currencySymbol">$</span>110.00-->
                <!--                    </span>-->
                <!--                </td>-->
                <!--            </tr>-->
                <!--            <tr class="cart-subtotal shipping">-->
                <!--                <th>Shipping:</th>-->
                <!--                <td data-title="Subtotal">-->
                <!--                    <div class="checkbox">-->
                <!--                        <label>-->
                <!--                            <input type="radio" name="shipping" checked> Free Shipping-->
                <!--                            <span class="checkmark"></span>-->
                <!--                        </label>-->
                <!--                        <label>-->
                <!--                            <input type="radio" name="shipping"> Local pickup: <span>$</span><span>0.00</span>-->
                <!--                            <span class="checkmark"></span>-->
                <!--                        </label>-->
                <!--                    </div>-->
                <!--                    <span>Calculate shipping</span>-->
                <!--                </td>-->
                <!--            </tr>-->
                <!--            <tr class="cart-subtotal">-->
                <!--                <th>Service <span>(estimated for Vietnam)</span></th>-->
                <!--                <td data-title="Subtotal">-->
                <!--                    <span class="woocommerce-Price-amount amount">-->
                <!--                        <span class="woocommerce-Price-currencySymbol">$</span>5.60-->
                <!--                    </span>-->
                <!--                </td>-->
                <!--            </tr>-->
                <!--            <tr class="order-total border-0">-->
                <!--                <th>Total</th>-->
                <!--                <td data-title="Total">-->
                <!--                    <span class="woocommerce-Price-amount amount">-->
                <!--                        <span class="woocommerce-Price-currencySymbol">$</span>64.69-->
                <!--                    </span>-->
                <!--                </td>-->
                <!--            </tr>-->
                <!--        </table>-->
                <!--    </div>-->
                    
                <!--</section>-->
            </form>
		</div>

@endsection
@push('script')
    <script>

        (function($) {
            "use strict";

            var fileName = '{{ $job->file_name }}';
            var files = fileName.split(",");
            var i;
            var j;
            var inputs = $("input[type=checkbox]");
            for(i = 0; i<files.length;i++){
                var file = files[i];
                for(j = 0;j<inputs.length;j++){
                    var checkboxVal = $(inputs[j]).val();
                    if(checkboxVal == file){
                        $(inputs[j]).attr( 'checked', true );
                    }
                }
                
            }
            if(fileName){
                $("#choiceOption").css('display','block');
            }
            else{
                $("#choiceOption").css('display','none');
            }
            $("#fileOption").change(function(){
                $("#choiceOption").css('display','none');
                var value = $(this).val();
                if(value == 2){
                    $("#choiceOption").css('display','block');
                }
            });

            $('#category').change(function() {
                var subcategory_id = '{{ $job->subcategory_id }}';
                $("#subcategory").html("");
                var data = [];
                @foreach ($categories as $category)
                    @foreach ($category->subcategory as $item)
                        data.push({ id: '{{ $item->id }}', category_id:'{{ $item->category_id }}', name:
                        '{{ $item->name }}' });
                    @endforeach
                @endforeach
                var id = $(this).val();
                $("#subcategory").prepend(`<option value="" selected disabled>Select One</option>`);
                data.forEach(value => {
                    if (value.category_id == id) {
                        $("#subcategory").append('<option value='+value.id+' '+ (value.id == subcategory_id ? 'selected': '') +'>'+value.name+'</option>');
                    }
                });
            }).change();

            $(".workers").on('change input',function(){
                
                var worker = $(this).val();
                var rate = $('.rate').val();
                var total = rate * worker;
                $('.total').val(total);
            });

            $(".rate").on('change input',function(){

                var rate = $(this).val();
                var worker = $('.workers').val();
                var total = rate * worker;
                $('.total').val(total);

            });


            
           
        })(jQuery);

        function previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").css("background-image", "url(" + reader.result + ")");
                }
                reader.readAsDataURL(file);
            }
        }
        
        $(document).ready(function(){
        
        
        $(".mb-btn-check").click(function(){
                var continent = $(this).attr('data-id');
                // alert(continent)
                $.ajax({
                    url: '/user/job/getcountry',
                    data: {code: continent, _token: "{{ csrf_token() }}" },
                    method: 'post',
                    success: function(res){
                        // console.log(res);
                        $(".mb-countries").html("");
                        $(".mb-countries").append('<h3 class="mb-h3">SELECT ALL COUNTRIES YOU WANT TO EXCLUDE FROM THE SELECTED ZONE (OPTIONAL)</h3>');
                        $.each(res, function(index, item){
                            // console.log(res[index].name);
                            // $("h3.mb-h3").after().html("");
                            
                            var _html = '<div class="col-md-2"><input type="checkbox" class="btn-check" id="'+res[index].country_id+'" name="country[]" autocomplete="off" /><label style="font-size: 12px;" class="btn btn-outline-success border-1 border  btn-sm small" for="'+res[index].country_id+'">'+res[index].name+'</label></div>';
                                
                            $(".mb-countries").append(_html);
                        });
                    }
                });
                
            });
            
            $(".mb-btn-check1").click(function(){
                var continent = $(this).attr('data-id');
                // alert(continent)
                $.ajax({
                    url: '/user/job/getsubcategory',
                    data: {id: continent, _token: "{{ csrf_token() }}" },
                    method: 'post',
                    success: function(res){
                        // console.log(res);
                        $(".mb-subcategories").html("");
                        $(".mb-subcategories").append('<h3 class="mb-cat-h3">Sub Category</h3>');
                        $.each(res, function(index, item){
                            // console.log(res[index].name);
                            
                            
                            var _html = '<div class="col-md-2"><input type="radio" class="btn-check subcategory" value="'+res[index].id+'" id="sc'+res[index].id+'" name="subcategory[]" autocomplete="off" /><label style="font-size: 12px;" class="btn btn-outline-success border-1 border  btn-sm small" for="sc'+res[index].id+'">'+res[index].name+'</label></div>';
                                
                            $(".mb-subcategories").append(_html);
                        });
                    }
                });
                
            });
            
            
            $("#quantity, #promotion").change(function(){
                var subcategory = $(".subcategory");
                var sc = "";
                var quantity = $("#quantity").val();
                $.each(subcategory, function(index, item){
                    if ($(this).is(":checked")) {
                       sc = $(this).val();
                       return false;
                    }else{
                        // alert('Please select subcategory.');
                        // return false;
                    }
                })
                
                // alert(sc);
                $.ajax({
                    url: '/user/job/getcategory',
                    data: {subcategory: sc, _token: "{{ csrf_token() }}" },
                    method: 'post',
                    success: function(res){
                        // console.log(res.min_price);
                        
                        var cat_price = res.min_price;
                        var speed = res.speed;
                        var budget = quantity * cat_price;
                        var percentage = 5;
                        var totalWidth = budget;
                        
                        var commission = (percentage / 100) * totalWidth; 
                        var promotion = $("#promotion").val();
                        if(promotion == "yes")
                        {
                            promotion = 1;
                        }else{
                            promotion = 0;
                        }
                        var total_budget = commission + budget + promotion;
                        console.log(total_budget);
                        $("#workerwillearn").val(cat_price);
                        $("#total_budget").val(total_budget);
                        $("input[name='speed']").val(speed);
                        
                        
                    }
                });
                
            });
    });
    </script>
    
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" class="form-control form--control" name="step[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
         // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input style="max-width: 85%" type="text" name="description[]" class="form-control m-input" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
    });
</script>
    
@endpush
