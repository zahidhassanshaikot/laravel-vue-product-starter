<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ getStorageImage(config('settings.site_logo'),false,'logo') }}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ getStorageImage(config('settings.wide_site_logo'),false,'wide_logo') }}" alt="" height="17">
                                </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ getStorageImage(config('settings.site_logo'),false,'logo') }}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{ getStorageImage(config('settings.wide_site_logo'),false,'wide_logo') }}" class="w-100" alt="" height="60">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <div class="d-flex">
            <!-- App Search-->
{{--            <form class="app-search d-none d-lg-block">--}}
{{--                <div class="position-relative">--}}
{{--                    <input type="text" class="form-control" placeholder="Search...">--}}
{{--                    <span class="fa fa-search"></span>--}}
{{--                </div>--}}
{{--            </form>--}}

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                       aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

{{--            <div class="dropdown d-inline-block">--}}
{{--                <button type="button" class="btn header-item noti-icon waves-effect"--}}
{{--                        id="page-header-notifications-dropdown"--}}
{{--                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    <i class="mdi mdi-bell-outline"></i>--}}
{{--                    <span class="badge bg-danger rounded-pill">3</span>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"--}}
{{--                     aria-labelledby="page-header-notifications-dropdown">--}}
{{--                    <div class="p-3">--}}
{{--                        <div class="row align-items-center">--}}
{{--                            <div class="col">--}}
{{--                                <h5 class="m-0 font-size-16"> Notifications (258) </h5>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div data-simplebar style="max-height: 230px;">--}}
{{--                        <a href="" class="text-reset notification-item">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-xs">--}}
{{--                                        <span class="avatar-title bg-success rounded-circle font-size-16">--}}
{{--                                            <i class="mdi mdi-cart-outline"></i>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <h6 class="mb-1">Your order is placed</h6>--}}
{{--                                    <div class="font-size-12 text-muted">--}}
{{--                                        <p class="mb-1">Dummy text of the printing and typesetting industry.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}

{{--                        <a href="" class="text-reset notification-item">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-xs">--}}
{{--                                                    <span class="avatar-title bg-warning rounded-circle font-size-16">--}}
{{--                                                        <i class="mdi mdi-message-text-outline"></i>--}}
{{--                                                    </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <h6 class="mb-1">New Message received</h6>--}}
{{--                                    <div class="font-size-12 text-muted">--}}
{{--                                        <p class="mb-1">You have 87 unread messages</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}

{{--                        <a href="" class="text-reset notification-item">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-xs">--}}
{{--                                                    <span class="avatar-title bg-info rounded-circle font-size-16">--}}
{{--                                                        <i class="mdi mdi-glass-cocktail"></i>--}}
{{--                                                    </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <h6 class="mb-1">Your item is shipped</h6>--}}
{{--                                    <div class="font-size-12 text-muted">--}}
{{--                                        <p class="mb-1">It is a long established fact that a reader will</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}

{{--                        <a href="" class="text-reset notification-item">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-xs">--}}
{{--                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">--}}
{{--                                                        <i class="mdi mdi-cart-outline"></i>--}}
{{--                                                    </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <h6 class="mb-1">Your order is placed</h6>--}}
{{--                                    <div class="font-size-12 text-muted">--}}
{{--                                        <p class="mb-1">Dummy text of the printing and typesetting industry.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}

{{--                        <a href="" class="text-reset notification-item">--}}
{{--                            <div class="d-flex">--}}
{{--                                <div class="flex-shrink-0 me-3">--}}
{{--                                    <div class="avatar-xs">--}}
{{--                                                    <span class="avatar-title bg-danger rounded-circle font-size-16">--}}
{{--                                                        <i class="mdi mdi-message-text-outline"></i>--}}
{{--                                                    </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <h6 class="mb-1">New Message received</h6>--}}
{{--                                    <div class="font-size-12 text-muted">--}}
{{--                                        <p class="mb-1">You have 87 unread messages</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="p-2 border-top">--}}
{{--                        <div class="d-grid">--}}
{{--                            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">--}}
{{--                                View all--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->avatar_url }}"
                         alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('users.edit', auth()->id()) }}"><i
                            class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a onclick="event.preventDefault();
                                        this.closest('form').submit();"
                           class="dropdown-item text-danger"
                           href="javascript:void(0)">
                            <i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
