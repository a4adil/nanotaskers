@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="job-category padding-top padding-bottom">
    <div class="container">
        <div class="row gy-3 pb-4 justify-content-center justify-content-md-between align-items-center">
            <div class="col-lg-6">
                <h4 class="text--base">@lang('Total') {{ count($jobs) }} @lang('jobs found')</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-wrap justify-content-lg-end">
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
            </div>
        </div>
        <div class="row gy-5">
            <div class="col-lg-12 col-md-12">
                <div class="announcement__details" id="jobs">
                    @include($activeTemplate.'partials.jobs')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>

    (function($){
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
            var date = dateVal;
            var sort = sortVal;
            var search = '{{ $search }}';
            var category = '{{ $category }}';

            $.ajax({
                url: "{{ route('search.jobs.sort') }}",
                method: "get",
                data: {
                    'date':date,
                    'sort':sort,
                    'search':search,
                    'category':category
                },
                success: function(response){
                    $('#jobs').html(response);
                }
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
            var search = '{{ $search }}';
            var category = '{{ $category }}';
            $.ajax({
                url:"{{ url('/search/jobs/pagination?page=') }}"+page,
                data: {
                    'date':date,
                    'sort':sort,
                    'search':search,
                    'category':category
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
