
<div class="col-lg-4 col-xl-3">
    <div class="dashboard__sidebar">
        <div class="user__profile">
            <div class="user__profile-thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['size']) }}"
                    alt="@lang('User')">
            </div>
            <div class="user__profile-content">
                <h4 class="user__profile-title">{{ Auth::user()->fullname }}</h4>
                <span class="designation">{{ Auth::user()->email }}</span>
            </div>
        </div>
        <ul class="dashboard__sidebar__menu">
            <li>
                <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}">@lang('Dashboard')</a>
            </li>
            <li class="has__submenu">
                <a href="#0">@lang('Job')</a>
                <ul class="sidebar__submenu">
                    @if(Auth::user()->user_type == 2)
                    <li><a href="{{ route('user.job.create') }}" class="{{ menuActive('user.job.create') }}">@lang('Create Job')</a></li>
                    <li><a href="{{ route('user.job.history') }}" class="{{ menuActive('user.job.history') }}">@lang('Job History')</a></li>
                    @endif
                    <li><a href="{{ route('user.job.apply') }}" class="{{ menuActive('user.job.apply') }}">@lang('Applied Jobs')</a></li>
                    <li><a href="{{ route('user.job.finished') }}" class="{{ menuActive('user.job.finished') }}">@lang('Finished Jobs')</a></li>
                </ul>
            </li>
            {{-- <li><a href="{{ route('user.finished.job') }}" class="{{ menuActive('user.finished.job') }}">@lang('My Finished Jobs')</a></li> --}}
            
            @if(Auth::user()->user_type == 2)
            <li><a href="#0">@lang('Deposit')</a>
                <ul class="sidebar__submenu">
                    <li><a href="{{ route('user.deposit') }}" class="{{ menuActive('user.deposit') }}">@lang('Deposit Now')</a></li>
                    <li><a href="{{ route('user.deposit.history') }}" class="{{ menuActive('user.deposit.history') }}">@lang('Deposit History')</a></li>
                </ul>
            </li>
            @endif
            <li><a href="#0">@lang('Withdraw')</a>
                <ul class="sidebar__submenu">
                    <li><a href="{{ route('user.withdraw') }}" class="{{ menuActive('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                    <li><a href="{{ route('user.withdraw.history') }}" class="{{ menuActive('user.withdraw.history') }}">@lang('Withdraw History')</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('user.transaction') }}" class="{{ menuActive('user.transaction') }}">
                    @lang('Transaction')
                </a>
            </li>
            <li><a href="#0">@lang('Support Ticket')</a>
                <ul class="sidebar__submenu">
                    <li><a href="{{ route('ticket.open') }}" class="{{ menuActive('ticket.open') }}">@lang('Create Ticket')</a></li>
                    <li><a href="{{ route('ticket') }}" class="{{ menuActive('ticket') }}">@lang('Ticket History')</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('user.profile.setting') }}"class="{{ menuActive('user.profile.setting') }}">@lang('Profile')</a>
            </li>
            <li>
                <a href="{{ route('user.change.password') }}" class="{{ menuActive('user.change.password') }}">
                    @lang('Change Password')
                </a>
            </li>
            <li>
                <a href="{{ route('user.twofactor') }}"
                    class="{{ menuActive('user.twofactor') }}">@lang('2FA')</a>
            </li>
            <li><a href="{{ route('user.logout') }}">@lang('Sign Out')</a></li>
        </ul>
        <span class="btn btn-close dashboard__sidebar__close d-lg-none"></span>
    </div>
</div>
