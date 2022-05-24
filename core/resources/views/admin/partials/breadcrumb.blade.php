<div class="row align-items-center mb-30 justify-content-between">
    <div class="col-lg-3 col-md-3">
        <h6 class="page-title">{{ __($pageTitle) }}</h6>
    </div>
    <div class="col-lg-9 col-md-9 text-sm-right">
        <div class="d-flex  flex-wrap align-items-center mt-md-0 mt-3 right-part justify-content-md-end" style="gap: 10px">
            @stack('breadcrumb-plugins')
        </div>
    </div>
</div>
