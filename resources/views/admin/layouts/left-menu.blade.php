<ul class="metismenu" id="menu" style="padding-top: 5rem; ">
    <li>
        <a href="{{ route('admin.dashboard') }}">
            <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>
    @if (Auth::user()->role_id == 1)
        <li>
            <a href="{{ route('admin.banner.index') }}">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Banner</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.email.settings.index') }}">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Email Setting</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.email.settings.index') }}">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Role</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.product.index') }}">
                <div class="parent-icon"><i class='bx bxs-add-to-queue'></i></div>
                <div class="menu-title">Product</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.shops.index') }}">
                <div class="parent-icon"><i class='bx bxs-add-to-queue'></i></div>
                <div class="menu-title">Shop</div>
            </a>
        </li>
        <li class="menu-item has-submenu">
            <a href="#" class="">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Categories</div>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.category.index') }}">Add Categories</a></li>
                <li><a href="{{ route('admin.sub-category.index') }}">Add Subcategories</a></li>
            </ul>
        </li>

        <li class="menu-item has-submenu">
            <a href="{{ route('admin.orders.index') }}" class="">
                <div class="parent-icon"><i class='bx bxs-package'></i></div>
                <div class="menu-title">Orders</div>
            </a>
        </li>

        {{-- ✅ INVENTORY MENU START --}}
        @php
            $shops = \App\Models\Shop::all();
        @endphp
        <li class="menu-item has-submenu">
            <a href="#">
                <div class="parent-icon"><i class='bx bx-archive-in'></i></div>
                <div class="menu-title">Inventory</div>
            </a>
            <ul class="submenu">
                <!-- Warehouse Stock -->
                <li>
                    <a href="{{ route('admin.inventory.index') }}">
                        <div class="menu-title">Warehouse Stock</div>
                    </a>
                </li>

                <!-- Shops with submenus -->
                <li class="menu-item has-submenu">
                    <a href="#">
                        <div class="menu-title">Shops</div>
                    </a>
                    <ul class="submenu">
                        @foreach($shops as $shop)
                            <li><a href="{{ route('admin.inventory.shop-stock', $shop->id) }}">-> {{ $shop->shop_name; }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <!-- Stock Movement Logs -->
                <li>
                    <a href="{{ route('admin.inventory.movements') }}">
                        <div class="menu-title">Stock Movement Logs</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ✅ INVENTORY MENU END --}}
    @endif
    @if (Auth::user()->role_id == 3)
        <li>
            <a href="{{ route('admin.shop.product.list') }}">
                <div class="parent-icon"><i class='bx bxs-add-to-queue'></i></div>
                <div class="menu-title">Product</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.shop.users.index') }}">
                <div class="parent-icon"><i class='bx bxs-customize'></i></div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.shop.order.list') }}">
                <div class="parent-icon"><i class='bx bxs-add-to-queue'></i></div>
                <div class="menu-title">Order</div>
            </a>
        </li>
        <li class="menu-item has-submenu">
            <a href="#">
                <div class="parent-icon"><i class='bx bx-archive-in'></i></div>
                <div class="menu-title">Inventory</div>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.shop.inventory.index') }}">Current Stock</a></li>
                <li><a href="{{ route('admin.shop.inventory.movements') }}">Stock Movement Logs</a></li>
                {{-- <li><a href="{{ route('admin.shop.inventory.lowstock') }}">Low Stock Report</a></li> --}}
            </ul>
        </li>
    @endif

</ul>
