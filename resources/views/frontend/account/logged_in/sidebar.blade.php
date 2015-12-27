<div class="sidebar-menu">
    <div class="user-picture">
        @if(empty(\Illuminate\Support\Facades\Auth::user()->profile->profile_picture))
            <img src="{{ asset('assets/frontend/images/user-icon.png') }}">
        @else
            <img src="{{ url('images/profile_picture/'.\Illuminate\Support\Facades\Auth::user()->profile->profile_picture) }}" class="img-rounded">
        @endif

        <div class="user-picture-detail">
            <div>{{ trans('account.interface.welcome') }}</div>
            <h4 class="user-picture-name text-uppercase">{{ \Illuminate\Support\Facades\Auth::user()->username }}</h4>
            <a href="{{ route('frontend.account.profile') }}" class="edit-user-profile">{{ trans('account.interface.edit_profile_btn') }}</a>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="sidebar-nav row">
        <ul>
            <li class="{{ $active_section=='account/dashboard'?'active':'' }}"><a href="{{ route('frontend.account.dashboard') }}"><img src="{{ asset('assets/frontend/images/icon-user-dashboard.png') }}" alt=""> <span>{{ trans('account.sidebar.dashboard_btn') }}</span></a></li>
            <li class="{{ preg_match('/account\/inbox/', $active_section)?'active':'' }}"><a href="{{ route('frontend.account.inbox') }}"><img src="{{ asset('assets/frontend/images/icon-user-inbox.png') }}" alt=""> <span>{{ trans('account.sidebar.inbox_btn') }}</span></a></li>
            <li class="{{ preg_match('/account\/viewings/', $active_section)?'active':'' }}"><a href="{{ route('frontend.account.viewings') }}"><img src="{{ asset('assets/frontend/images/icon-user-viewings.png') }}" alt=""> <span>{{ trans('account.sidebar.viewings_btn') }}</span></a></li>
            <li class="{{ preg_match('/^property/', $active_section)?'active':'' }}"><a href="{{ route('frontend.property.index', ['for' => 'sell']) }}"><img src="{{ asset('assets/frontend/images/icon-user-properties.png') }}" alt=""> <span>{{ trans('account.sidebar.properties_btn') }}</span></a></li>
            <li class="{{ $active_section=='sales'?'active':'' }}"><a href="account-fullsales.php"><img src="{{ asset('assets/frontend/images/icon-user-fullsales.png') }}" alt=""> <span>{{ trans('account.sidebar.full_sales_progression_btn') }}</span></a></li>
        </ul>
    </div>
</div>