@php
    $data = getContent('job_category.content',true);
    $categories    = App\Models\Category::where('featured', 1)->orderBy('name')->with('subcategory')->get();
@endphp
<section class="job-category padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="section__header text-center">
                    <h2 class="section__header-title">{{ __($data->data_values->heading) }}</h2>
                    <p>{{ __($data->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div>
        <div class="row g-3 g-xl-4 justify-content-center">
            @foreach ($categories->take(8) as $category)
                <div class="col-lg-4 col-xl-3 col-md-4 col-sm-6">
                    <div class="category__item">
                        <div class="category__item-icon">
                            <img src="{{ getImage(imagePath()['category']['path'] . '/' . $category->image, imagePath()['category']['size']) }}" alt="@lang('icon')">
                        </div>
                        <div class="category__item-content">
                            <h5 class="title">{{ __($category->name) }}</h5>
                            <p class="mt-2">{{ __($category->short_description) }}</p>
                        </div>
                        @php
                            $post = countPost($category->id);
                        @endphp
                        <span class="job-count badge badge--md">{{ $post }}</span>
                        <a class="job_cate" href="{{ route('all.subcategory', ['id' => $category->id, 'name' => slug($category->name)]) }}"></a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 mt-4">
                <div class="section__header text-center">
                   <a href="{{ route('all.category') }}" class="btn btn--base btn--lg">@lang('View all')</a>
                </div>
            </div>
        </div>
    </div>
</section>
