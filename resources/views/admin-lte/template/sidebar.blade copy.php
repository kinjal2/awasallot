<style>
.blink-menu {
    animation: glow 1s infinite alternate;
}

@keyframes glow {
    from {
        color: #fff;
    }
    to {
        color: #ffc107;
        text-shadow: 0 0 10px #ffc107;
    }
}

.burst-new {
    position: relative;
    color: #fff;
    background: #ff3b3b;
    padding: 6px;
    border-radius: 50%;
}

.burst-new::after {
    content: "NEW";
    position: absolute;
    top: -6px;
    right: -12px;
    background: orange;
    color: white;
    font-size: 8px;
    padding: 2px 4px;
    border-radius: 3px;
}

.badge-danger {
    animation: blink 1s infinite;
}

@keyframes blink {
    0% { opacity:1; }
    50% { opacity:0.3; }
    100% { opacity:1; }
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="#" class="brand-link">

        <img src="{{ URL::asset('images/national_emblem.png') }}"
             alt="National Logo"
             style="height:130%">

    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-5">

            @if(isset($dynamicMenus) && count($dynamicMenus) > 0)

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                @foreach($dynamicMenus as $menu)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | CHECK CHILD MENU
                    |--------------------------------------------------------------------------
                    */

                    $hasChildren = $menu->children->count() > 0;

                    /*
                    |--------------------------------------------------------------------------
                    | AUTO OPEN ACTIVE PARENT
                    |--------------------------------------------------------------------------
                    */

                    $isMenuOpen = false;

                    foreach ($menu->children as $child) {

                        if (request()->routeIs($child->route_name)) {

                            $isMenuOpen = true;
                            break;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | MENU URL
                    |--------------------------------------------------------------------------
                    */

                    $menuUrl = 'javascript:;';

                    if (
                        !$hasChildren &&
                        !empty($menu->route_name) &&
                        Route::has($menu->route_name)
                    ) {

                        $menuUrl = route($menu->route_name);

                    }

                @endphp

                <li class="nav-item {{ $hasChildren ? 'has-treeview' : '' }} {{ $isMenuOpen ? 'menu-open' : '' }}">

                    <a href="{{ $menuUrl }}"
                       class="nav-link {{ request()->routeIs($menu->route_name) ? 'active' : '' }} {{ $menu->menu_title == 'Quarter Draw' ? 'blink-menu' : '' }}">

                        <i class="{{ $menu->icon }}"></i>

                        <p>

                            {{ $menu->menu_title }}

                            @if($menu->menu_title == 'Quarter Draw')

                                <span class="badge badge-danger ml-2">
                                    NEW
                                </span>

                            @endif

                            @if($hasChildren)

                                <i class="right fas fa-angle-left"></i>

                            @endif

                        </p>

                    </a>

                    @if($hasChildren)

                    <ul class="nav nav-treeview">

                        @foreach($menu->children as $submenu)

                        @php

                            $submenuUrl = 'javascript:;';

                            if (
                                !empty($submenu->route_name) &&
                                Route::has($submenu->route_name)
                            ) {

                                $submenuUrl = route($submenu->route_name);

                            }

                        @endphp

                        <li class="nav-item">

                            <a href="{{ $submenuUrl }}"
                               class="nav-link {{ request()->routeIs($submenu->route_name) ? 'active' : '' }}">

                                <i class="{{ $submenu->icon }}"></i>

                                <p>{{ $submenu->menu_title }}</p>

                            </a>

                        </li>

                        @endforeach

                    </ul>

                    @endif

                </li>

                @endforeach

            </ul>

            @endif

        </nav>

    </div>

</aside>