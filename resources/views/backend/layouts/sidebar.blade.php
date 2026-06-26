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
                        <img src="{{ asset('backend/assets/img/icons/transcation.svg') }}" alt="img">
                        <span>Point of sale</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/product.svg') }}"
                            alt="img"><span>
                            Inventory </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('category.index') }}" class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                                <span>Category</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('unit.index') }}" class="{{ request()->routeIs('unit.*') ? 'active' : '' }}">
                                <span>Units</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('brand.index') }}" class="{{ request()->routeIs('brand.*') ? 'active' : '' }}">
                                <span>Brands</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                                <span>Products</span>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/purchase1.svg') }}"
                            alt="img"><span>
                            Purchases </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('purchase.index') }}" class="{{ request()->routeIs('purchase.index') ? 'active' : '' }}">
                                <span>All Purchase</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('purchase.create') }}" class="{{ request()->routeIs('purchase.create') ? 'active' : '' }}">
                                <span>Create Purchase</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('purchase.restorePurchase') }}" class="{{ request()->routeIs('purchase.*') ? 'active' : '' }}">
                                <span>Trashed Purchases</span>
                            </a>
                        </li>



                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/sales1.svg') }}"
                            alt="img"><span>
                            Sales </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                                <span>All Sales</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('held-orders.index') }}" class="{{ request()->routeIs('held-orders.*') ? 'active' : '' }}">
                                <span>On Hold</span>
                            </a>
                        </li>

                    </ul>



                </li>



                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/return1.svg') }}"
                            alt="img"><span>
                            Return </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('returns.index') }}" class="{{ request()->routeIs('returns.index') ? 'active' : '' }}">
                                <span>Sale Return List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('returns.create') }}" class="{{ request()->routeIs('returns.create') ? 'active' : '' }}">
                                <span>Add Sale Return</span>
                            </a>
                        </li>

                    </ul>



                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/expense1.svg') }}"
                            alt="img"><span>
                            Expenses </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('expense-categories.index') }}" class="{{ request()->routeIs('expense-categories.index') ? 'active' : '' }}">
                                <span>Expense Category</span>
                            </a>
                        </li>
                         <li>
                            <a href="{{ route('expenses.index') }}" class="{{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                                <span>Expense </span>
                            </a>
                        </li>
                         <li>
                            <a href="{{ route('expense-reports.index') }}" class="{{ request()->routeIs('expense-reports.index') ? 'active' : '' }}">
                                <span>Expense Reports </span>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/time.svg') }}"
                            alt="img"><span>
                            Reports </span> <span class="menu-arrow"></span></a>
                    <ul>


                        <li>
                            <a href="{{ route('returns.index') }}" class="{{ request()->routeIs('returns.index') ? 'active' : '' }}">
                                <span>Sale Return List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('returns.create') }}" class="{{ request()->routeIs('returns.create') ? 'active' : '' }}">
                                <span>Add Sale Return</span>
                            </a>
                        </li>

                    </ul>
                </li>






                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/quotation1.svg') }}"
                            alt="img"><span>
                            Customers</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('customer.index') }}" class="{{ request()->routeIs('customer.*') ? 'active' : '' }}">
                                <span> Customers</span>
                            </a>

                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/places.svg') }}"
                            alt="img"><span>
                            Suppliers</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('supplier.index') }}" class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                                <span> Suppliers</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/users1.svg') }}"
                            alt="img"><span>
                            For Admin Only </span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.user.show') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                <span> Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                <span> Roles</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                                <span> Permissions</span>
                            </a>

                        <li>
                            <a href="{{ route('admin.roles_permissions.index') }}" class="{{ request()->routeIs('admin.roles_permissions.*') ? 'active' : '' }}">
                                <span> Roles & Permissions</span>
                            </a>
                        </li>


                    </ul>
                </li>
                     <li>

                    <a href="{{ route('sticky-notices.sticky_notices') }}" class="{{ request()->routeIs('sticky-notices.sticky_notices') ? 'active' : '' }}"><img src="{{ asset('backend/assets/img/icons/edit.svg') }}"
                            alt="img"><span>
                            Sticky Notices</span> <span class="menu-arrow"></span></a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('backend/assets/img/icons/settings.svg') }}"
                            alt="img"><span>
                            Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.user.show') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                <span> Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                <span> Roles</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                                <span> Permissions</span>
                            </a>

                        <li>
                            <a href="{{ route('admin.roles_permissions.index') }}" class="{{ request()->routeIs('admin.roles_permissions.*') ? 'active' : '' }}">
                                <span> Roles & Permissions</span>
                            </a>

                        </li>


                    </ul>
                </li>

           

            </ul>



        </div>
    </div>
</div>