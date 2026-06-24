<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>


                <li class="{{ request()->route()->getName() == 'admin.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->route()->getName() == 'pos.index' ? 'active' : '' }}">
                    <a href="{{ route('pos.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>POS</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            Inventory </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                            <a href="{{ route('category.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Category</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('unit.*') ? 'active' : '' }}">
                            <a href="{{ route('unit.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Units</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('brand.*') ? 'active' : '' }}">
                            <a href="{{ route('brand.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Brands</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Products</span>
                            </a>
                        </li>

                    </ul>
                </li>
                

                <li class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                    <a href="{{ route('supplier.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Suppliers</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('customer.*') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}">
                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Customers</span>
                    </a>
                </li>

                 <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            Purchases </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li class="{{ request()->routeIs('purchase.index') ? 'active' : '' }}">
                            <a href="{{ route('purchase.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>All Purchase</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('purchase.create') ? 'active' : '' }}">
                            <a href="{{ route('purchase.create') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Create Purchase</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('purchase.trashed') ? 'active' : '' }}">
                            <a href="{{ route('purchase.restorePurchase') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Trashed Purchases</span>
                            </a>
                        </li>

                        

                    </ul>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            For Admin Only </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.user.show') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Users</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Roles</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Permissions</span>
                            </a>

                        <li class="{{ request()->routeIs('admin.roles_permissions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles_permissions.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Roles & Permissions</span>
                            </a>
                        </li>


                    </ul>
                </li>

                {{--               
                  
               
           

        
                    <li class="submenu">
                        <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/product.svg') }}"
                                alt="img"><span>
                                Product Attributes</span> <span class="menu-arrow"></span></a>
                        <ul>
                            @can('view_colors')
                                <li class="{{ request()->routeIs('colors.*') ? 'active' : '' }}">
                                    <a href="{{ route('colors.index') }}">
                                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                        <span> Colors</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view_varients')
                                <li class="{{ request()->routeIs('attribute.*') ? 'active' : '' }}">
                                    <a href="{{ route('attribute.index') }}">
                                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                        <span> Attributes</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('attributevalue.*') ? 'active' : '' }}">
                                    <a href="{{ route('attributevalue.index') }}">
                                        <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                        <span> Attributes Values</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
               

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Manage Products </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> All Products</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <a href="{{ route('product.create') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Create Product</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <a href="{{ route('product.restore') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span> Restore Product</span>
                            </a>
                        </li>
                    </ul>

                </li>



                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Manage Sales </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                            <a href="{{ route('sales.index') }}">
                                <img src="{{ asset('backend/assets/img/icons/users1.svg') }}" alt="img">
                                <span>Sales</span>
                            </a>
                        </li>

                    </ul>

                </li>



               
                   
           --}}

            </ul>



        </div>
    </div>
</div>
