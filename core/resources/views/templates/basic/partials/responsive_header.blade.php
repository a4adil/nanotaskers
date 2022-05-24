<div class="dashboard__responsive__header d-flex align-items-center justify-content-between d-lg-none">
    <div class="thumb__wrapper d-flex align-items-center">
        <div class="thumb me-2">
            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['size']) }}"
                alt="@lang('freelancer')">
        </div>
        <span class="username">{{ Auth::user()->username }}</span>
    </div>
    <div class="dashboard__sidebar__toggler"><i class="las la-sliders-h"></i></div>
</div>
