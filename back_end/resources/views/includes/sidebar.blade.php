<nav class="sidebar ps ps--active-y">
    <!-- Sidebar Header -->
    <div class="sidebar-header d-none d-lg-block">
        <!-- Sidebar Toggle Pin Button -->
        <div class="sidebar-toogle-pin">
            <i class="icofont-tack-pin"></i>
        </div>
        <!-- End Sidebar Toggle Pin Button -->
    </div>
    <!-- End Sidebar Header -->

    <!-- Sidebar Body -->
    <div class="sidebar-body">
        <!-- Nav -->
        <ul class="nav">
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="icofont-home"></i>
                    <span class="link-title">الرئيسية</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('companies.index') ? 'active' : '' }}">
                <a href="{{ route('companies.index') }}">
                    <i class="icofont-building-alt"></i>
                    <span class="link-title">اعدادات المشروع </span>
                </a>
            </li>
                <li class="{{ request()->routeIs('cats.index') ? 'active' : '' }}">
<a href="{{ route('cats.index', ['id' => optional($company)->id]) }}">
                    <i class="icofont-building-alt"></i>
                    <span class="link-title">الفروع</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('all_ads') ? 'active' : '' }}">
                <a href="{{ route('all_ads') }}">
                    <i class="icofont-bullhorn"></i>
                    <span class="link-title">الحملات الاعلانية</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}">
                    <i class="icofont-users"></i>
                    <span class="link-title">المستخدمين</span>
                </a>
            </li>

             <li style="display: none;">
                <a href="{{ route('domain.index') }}">
                    <i class="icofont-building-alt"></i>
                    <span class="link-title">النطاقات</span>
                </a>
            </li>


        </ul>
    </div>
    <!-- End Sidebar Body -->
    <div class="ps__rail-x" style="left: 0px; bottom: -1200px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 1200px; height: 855px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 485px; height: 345px;"></div>
    </div>
</nav>
