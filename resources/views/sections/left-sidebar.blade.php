<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="{{ route('dashboard') }}" class="brand-link"><span class="brand-text fw-light">@lang('app.projectName')</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow "></i>
                        </p>
                    </a>

                </li>

                <li class="nav-item {{request()->routeIs('user.index') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            User Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"> <i class="nav-icon bi bi-circle"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item {{ request()->routeIs('news-category.index') || request()->routeIs('news.index') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            News Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('news-category.index') }}" class="nav-link {{ request()->routeIs('news-category.index') ? 'active' : '' }}"> <i class="nav-icon bi bi-circle"></i>
                                <p>News Category</p>
                            </a> </li>
                        <li class="nav-item"> <a href="{{ route('news.index') }}" class="nav-link {{ request()->routeIs('news.index') ? 'active' : '' }}"> <i class="nav-icon bi bi-circle"></i>
                                <p>News</p>
                            </a> </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('album.create') }}" class="nav-link"> <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Gallery
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                </li>

            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>
