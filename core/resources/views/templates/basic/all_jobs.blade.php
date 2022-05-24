@extends($activeTemplate.'layouts.frontend')
@push('style')
@endpush

@section('content')

<section class="job-category padding-top padding-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-end mb-3 mb-sm-4">
           <div class="search">
                <select class="nice-select sortPrice">
                    <option value="" selected disabled>@lang('Sort By Rate')</option>
                    <option value="low_to_high">@lang('Low to High')</option>
                    <option value="high_to_low">@lang('High to Low')</option>
                </select>
           </div>
            <div class="search ms-3">
                <select class="nice-select dateSort">
                    <option value="">@lang('Filter By')</option>
                    <option value="today">@lang("Today")</option>
                    <option value="weekly">@lang("Weekly")</option>
                    <option value="monthly">@lang("Monthly")</option>
                </select>
            </div>
        </div>
        <div class="row gy-5">
            <div class="col-lg-3 col-md-12 sidebar-right theiaStickySidebar">
                <div class="widget-box post-widget">
                    <h4 class="pro-title">@lang('Job Categories')</h4>
                    <ul class="latest-posts m-0">
                        <li>
                            <div class="post-thumb-category">
                                <input type="checkbox" id="check" name="category_id" value="all" class="categoryFilter">
                            </div>
                            <div class="post-info-category">
                                <label for="check">@lang('All Category')</label>
                            </div>
                        </li>
                        @foreach ($categories->take(20) as $category)     
                        <li>
                            <div class="post-thumb-category">
                                <input type="checkbox" id="check{{ $category->id }}" name="category_id"  value="{{ $category->id }}" class="categoryFilter">
                            </div>
                            <div class="post-info-category">
                                <label for="check{{ $category->id }}">{{ __($category->name) }}</label>
                            </div>
                        </li>
                        @endforeach
                        <li>
                            <div class="post-info-category">
                                <h6><a href="{{ route('all.category') }}" class="text--base">@lang('View all category')</a></h6>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="announcement__details position-relative" id="jobs">
                    <div class="position-relative">
                        <div id="overlay">
                            <div class="cv-spinner">
                                <span class="spinner"></span>
                            </div>
                        </div>
                        <div class="overlay-2" id="overlay2"></div>
                        @include($activeTemplate.'partials.jobs')
                    </div>

                </div>
            </div>
        </div> 
    </div>
</section>
@endsection

@push('style')
    <style>
        #overlay {
            position: absolute;
            top: 260px;
            left: 50%;
            transform: translate(-50%,-50%);
            display: none;
            z-index: 3;
            width: 100px;
            height: 100px;
        }

        
        .cv-spinner {
            height: 50%;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime .8s infinite linear
        }

        .overlay-2 {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            background: #fff;
            z-index: 2;
            display: none;
            opacity: .9;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg)
            }
        }
    </style>
@endpush

@push('script')
<script>
    
    (function($){

        $("#overlay, #overlay2").css('display', 'none');

        $('.categoryFilter').on('change',function(){
            var dateVal = $('.dateSort').val();
            var sortVal = $('.sortPrice').val(); 
            if($('#check').is(':checked')){
                $("input[type='checkbox'][name='category_id']").not(this).prop('checked', false);
            }  
            filterJob(dateVal,sortVal);
        });
        $('.sortPrice').on('change', function() {
            var sortVal = $(this).val();
            var dateVal = $('.dateSort').val();
            filterJob(dateVal,sortVal);
        });
        $('.dateSort').on('change', function() {
            var dateVal = $(this).val();
            var sortVal = $('.sortPrice').val();
            filterJob(dateVal,sortVal);
        });
        
        function filterJob(dateVal,sortVal){

            $("#overlay, #overlay2").fadeIn(300);

            var date = dateVal;
            var sort = sortVal;
            var category_id = [];
            $.each($("input[name='category_id']:checked"), function() {
                category_id.push($(this).val());
            });

            var pageUrl = "{{ route('all.jobs.sort') }}";
            $.ajax({
                url: pageUrl,
                method: "get",
                data: {
                    'date':date,
                    'sort':sort,
                    'category_id':category_id
                },
                
                success: function(response){  
                    $('#jobs').html(response);
                }
            }).done(function() {
                setTimeout(function(){
                    $("#overlay, #overlay2").fadeOut(300);
                },500);
            });
        }
    })(jQuery)
    $(document).ready(function(){
        
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            var dateVal = $('.dateSort').val();
            var sortVal = $('.sortPrice').val();
            fetch_data(page,dateVal,sortVal);
        });

        function fetch_data(page,dateVal,sortVal)
        {
            var date = dateVal;
            var sort = sortVal;
            var category_id = [];
            $.each($("input[name='category_id']:checked"), function() {
                category_id.push($(this).val());
            });
            
            $.ajax({
                url:"{{ url('/all/jobs/pagination/?page=') }}"+page,
                data: {
                    'date':date,
                    'sort':sort,
                    'category_id':category_id
                },
                success:function(response)
                {
                    $('#jobs').html(response);
                }
            });
        }

    });
</script>
@endpush