@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="job-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            @php echo $page->data_values->details @endphp
        </div>
    </div>
</section>
@endsection
