<style>
    .dropdown {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        overflow-x: hidden;
    }

    .dropdown a,
    .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        /* color: #0a0000; */
        display: block;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
        outline: none;
    }

    .dropdown-btn :hover {
        color: #111AE9;
    }

    .dropdown-item:hover {
        color: #111AE9;
    }

    .dropdown-container {
        margin: 1px;

    }

    .dropdown-container a img {
        /* padding: 1px;
        border: solid rgb(167, 171, 175) 1px; */
        margin-right: 10px;
    }

    .dropdown-container {
        margin: 1px;
        /* box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px; */
    }

    .drop-item-active {
        color: #111AE9;
        background-color: #F3F5F5 !important;
        width: 100%;
        /* color: #fff !important; */
    }
</style>

<div class="nav_inner">
    <ul class="nav_list">

        @if (auth()->user()->role->hasPermissionTo('dashboard'))
            <x-sidenav.nav name="Dashboard" :active="request()->is('/') ? 'menu-active' : ''" :href="route('dashboard')" :icon="[asset('images/homepage-icon.svg'), asset('images/homepage-icon-white.svg')]" />
        @endif
        @if (auth()->user()->role->hasPermissionTo('view customer'))
            <x-sidenav.nav name="Users" :active="request()->is('customers') ? 'menu-active' : ''" :href="route('customers.index')" :icon="[asset('images/users_3914283.svg'), asset('images/users_3914283.svg')]" />
        @endif
        @if (auth()->user()->role->hasPermissionTo('pos'))
            <x-sidenav.nav name="Point Of Sale" :active="request()->is('point-of-sale') ? 'menu-active' : ''" :href="route('pos')" :icon="[asset('images/pos-swipe-icon.svg'), asset('images/pos-swipe-icon-white.svg')]" />
        @endif
        @if (auth()->user()->role->hasPermissionTo('view order'))
            <x-sidenav.nav name="Orders" :active="request()->is('orders/list') ? 'menu-active' : ''" :href="route('orders.index')" :icon="[asset('images/orders-icon.svg'), asset('images/orders-icon-white.svg')]" />
        @endif
        @if (auth()->user()->role->hasPermissionTo('report'))
            <x-sidenav.nav name="Reports" :active="request()->is('reports') ? 'menu-active' : ''" :href="route('reports.index')" :icon="[asset('images/role.png'), asset('images/role.png')]" />
        @endif


        <li class="dropdown">

            <a href="javascript:void(0)" class="dropdown-btn">
                <i class="mb-2 icon1">
                    <img src="{{ asset('images/fmcg-products-icon.svg') }}" alt="">
                    <img src="{{ asset('images/fmcg-products-icon-white.svg') }}" alt="">
                </i>
                <span class="">Products <i class="fa fa-caret-down text-dark ms-2 " id="updownicon"></i></span>

            </a>
            <ul class="dropdown-container border-rounded mt-2"
                style="@if (request()->route()->getName() == 'suppliers.index' || request()->route()->getName() == 'categories.index') display:block @elseif(request()->route()->getName() == 'products.index' ||
                        request()->route()->getName() == 'generics.index' ||
                        request()->route()->getName() == 'units.index') display:block  @else display:none @endif">
                @if (auth()->user()->role->hasPermissionTo('view product'))
                    <li
                        class="dropdown-item {{ request()->route()->getName() == 'products.index' ? 'drop-item-active' : '' }}">

                        <a href="{{ route('products.index') }}" class="mb-1" style="padding-left: 0px;">
                            <img src="{{ asset('images/fmcg-products-icon.svg') }}" alt="" style="width: 16px">
                            Products
                        </a>
                    </li>
                @endif

                {{-- <li
                    class="dropdown-item {{ request()->route()->getName() == 'units.index' ? 'drop-item-active' : '' }}">
                    <a href="{{ route('units.index') }}" class="mb-1" style="padding-left: 0px;">
                        <img src="{{ asset('images/pharmacy-pills-icon.svg') }}" alt="" style="width: 16px">
                        Box Pattern
                    </a>
                </li> --}}
                {{-- <li
                    class="dropdown-item {{ request()->route()->getName() == 'units.index' ? 'drop-item-active' : '' }}">
                    <a href="{{ route('units.index') }}" class="mb-1" style="padding-left: 0px;">
                        <img src="{{ asset('images/pharmacy-pills-icon.svg') }}" alt="" style="width: 16px">
                        Box Pattern
                    </a>
                </li> --}}
                @if (auth()->user()->role->hasPermissionTo('view supplier'))
                    <li
                        class="dropdown-item {{ request()->route()->getName() == 'suppliers.index' ? 'drop-item-active' : '' }}">
                        <a href="{{ route('suppliers.index') }}" style="padding-left: 0px;">
                            <img src="{{ asset('images/truck-icon.svg') }}" alt="" style="width: 16px">
                            Suppliers
                        </a>
                    </li>
                @endif
                @if (auth()->user()->role->hasPermissionTo('view category'))
                    <li
                        class="dropdown-item {{ request()->route()->getName() == 'categories.index' ? 'drop-item-active' : '' }}">
                        <a href="{{ route('categories.index') }}" class="mb-1" style="padding-left: 0px;">
                            <img src="{{ asset('images/category-icon.svg') }}" alt="" style="width: 16px">
                            Category
                        </a>
                    </li>
                @endif
                @if (auth()->user()->role->hasPermissionTo('view pre-discount'))
                    <li
                        class="dropdown-item {{ request()->route()->getName() == 'pre-discounts.index' ? 'drop-item-active' : '' }}">
                        <a href="{{ route('pre-discounts.index') }}" class="mb-1" style="padding-left: 0px;">
                            <img src="{{ asset('images/category-icon.svg') }}" alt="" style="width: 16px">
                            Discounts
                        </a>
                    </li>
                @endif
                {{-- @if (auth()->user()->role->hasPermissionTo('view generic'))
                                <li
                                    class="dropdown-item {{ request()->route()->getName() == 'generics.index' ? 'drop-item-active' : '' }}">
                                    <a href="{{ route('generics.index') }}" style="padding-left: 0px;">
                                        <img src="{{ asset('images/generic-icon.svg') }}" alt="" style="width: 16px">
                                        Generics
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if (auth()->user()->role->hasPermissionTo('view purchase'))
                        <x-sidenav.nav name="Purchase" :active="request()->is('purchase') ? 'menu-active' : ''" :href="route('purchase.index')" :icon="[asset('images/cart-arrow-down-icon.svg'), asset('images/cart-arrow-down-icon-white.svg')]" />
                    @endif
                --}}
            </ul>

            <x-sidenav.nav name="Settings" :active="request()->is('settings/create') ? 'menu-active' : ''" :href="route('settings.create')" :icon="[asset('images/setting-icon.svg'), asset('images/setting-icon-white.svg')]" />
            {{-- <x-sidenav.nav name="prescriptions" :active="request()->is('priscription') ? 'menu-active' : ''" :href="route('priscription.index')" :icon="[asset('images/prescription-icon.svg'), asset('images/prescription-icon.svg')]" /> --}}
            @if (auth()->user()->role->hasPermissionTo('view role'))
                <x-sidenav.nav name="roles" :active="request()->is('roles') ? 'menu-active' : ''" :href="route('roles.index')" :icon="[asset('images/role.png'), asset('images/role.png')]" />
            @endif

        <li>
            <a href="#" class="logout-trigger">
                <i>
                    <img src={{ asset('images/nav7.png') }} alt="" />
                    <img src={{ asset('images/nav7_hov.png') }} alt="" />
                </i>

                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>

<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var updown = document.getElementById("updownicon");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                // updown.classList.remove("fa-caret-down");
                updown.classList.add("fa-caret-up");

            } else {
                dropdownContent.style.display = "block";
                // updown.classList.remove("fa-caret-up");
                // updown.classList.add(" fa-caret-down");
            }
        });
    }
</script>
