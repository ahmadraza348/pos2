<?php

use App\Http\Controllers\Admin\{AdminUserController,AuthController, BrandController, CategoryController,CustomerController,PosController, DashboardController, ProductController, RoleController, UnitController, SupplierController};
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\Admin\HeldOrderController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portfolio');
});

// Admin Routes
Route::prefix('admin')->controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('admin.login');
    Route::post('login/submit', 'login_submit')->name('admin.login.submit');
    Route::get('login/forget-password', 'forgetpass')->name('admin.forgetpass');
    Route::post('login/forget-password/submit', 'submitforgetpass')->name('admin.forgetpass.submit');
    Route::get('login/reset-password/{token}', 'show_reset_pass_form')->name('reset.password.get');
    Route::post('login/reset-password/{token}', 'submit_reset_pass_form')->name('reset.password.post');
});

Route::prefix('admin')->middleware('adminauth')->group(function () {
    // Dashboard, logout, own profile and sticky notices are available to any
    // authenticated admin and are intentionally left without a permission
    // check - they aren't part of the permission list and every admin needs
    // them to use the panel at all.
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('user')->controller(AdminUserController::class)->name('admin.user.')->group(function () {
        Route::get('/', 'show')->name('show')->middleware('can:view_admins');
        Route::get('/add', 'add')->name('add')->middleware('can:create_admins');
        Route::post('/store', 'store')->name('store')->middleware('can:create_admins');
        Route::get('/edit/{id}', 'edit')->name('edit')->middleware('can:edit_admins');
        Route::post('/update/{id}', 'update')->name('update')->middleware('can:edit_admins');
        Route::get('/delete/{id}', 'delete')->name('delete')->middleware('can:delete_admins');
        // Own profile - no permission required.
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile/save/{id}', 'profile_update')->name('profile.update');
    });

    Route::prefix('roles')->controller(RoleController::class)->name('admin.roles.')->group(function () {
        Route::get('/', 'all_roles')->name('index')->middleware('can:view_roles');
        Route::post('store', 'add_roles')->name('store')->middleware('can:create_roles');
        Route::get('edit/{role}', 'edit_roles')->name('edit')->middleware('can:edit_roles');
        Route::put('update/{role}', 'update_roles')->name('update')->middleware('can:edit_roles');
        Route::delete('delete/{role}', 'delete_roles')->name('delete')->middleware('can:delete_roles');
    });

    Route::prefix('permissions')->controller(RoleController::class)->name('admin.permissions.')->group(function () {
        Route::get('/', 'all_permissions')->name('index')->middleware('can:view_permissions');
        Route::post('store', 'add_permissions')->name('store')->middleware('can:create_permissions');
        Route::get('edit/{permission}', 'edit_permissions')->name('edit')->middleware('can:edit_permissions');
        Route::put('update/{permission}', 'update_permissions')->name('update')->middleware('can:edit_permissions');

        Route::delete('delete/{permission}', 'delete_permissions')->name('delete')->middleware('can:delete_permissions');
    });

    Route::prefix('roles-permissions')->controller(RoleController::class)->name('admin.roles_permissions.')->group(function () {
        Route::get('/', 'all_roles_permissions')->name('index')->middleware('can:view_roles_permissions');
        Route::get('/create', 'create_roles_permissions')->name('create')->middleware('can:create_roles_permissions');
        Route::post('store', 'store_roles_permissions')->name('store')->middleware('can:create_roles_permissions');
        Route::get('edit/{role_permission}', 'edit_roles_permissions')->name('edit')->middleware('can:edit_roles_permissions');
        Route::put('update/{role_permission}', 'update_roles_permissions')->name('update')->middleware('can:edit_roles_permissions');
        Route::delete('delete/{role_permission}', 'delete_roles_permissions')->name('delete')->middleware('can:delete_roles_permissions');
    });

    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_categories');
        Route::post('store', 'store')->name('store')->middleware('can:create_categories');
        Route::get('edit/{category}', 'edit')->name('edit')->middleware('can:edit_categories');
        Route::put('update/{category}', 'update')->name('update')->middleware('can:edit_categories');
        Route::delete('delete/{category}', 'destroy')->name('destroy')->middleware('can:delete_categories');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete')->middleware('can:delete_categories');
        Route::post('import', 'import')->name('import')->middleware('can:create_categories');
    });

    Route::prefix('brand')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_brands');
        Route::post('store', 'store')->name('store')->middleware('can:create_brands');
        Route::get('edit/{brand}', 'edit')->name('edit')->middleware('can:edit_brands');
        Route::put('update/{brand}', 'update')->name('update')->middleware('can:edit_brands');
        Route::delete('delete/{brand}', 'destroy')->name('destroy')->middleware('can:delete_brands');
    });

    Route::prefix('unit')->name('unit.')->controller(UnitController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_units');
        Route::post('store', 'store')->name('store')->middleware('can:create_units');
        Route::get('edit/{unit}', 'edit')->name('edit')->middleware('can:edit_units');
        Route::put('update/{unit}', 'update')->name('update')->middleware('can:edit_units');
        Route::delete('delete/{unit}', 'destroy')->name('destroy')->middleware('can:delete_units');
    });

    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_products');
        Route::get('create', 'create')->name('create')->middleware('can:create_products');
        Route::post('store', 'store')->name('store')->middleware('can:create_products');
        Route::get('edit/{product}', 'edit')->name('edit')->middleware('can:edit_products');
        Route::put('update/{product}', 'update')->name('update')->middleware('can:edit_products');
        Route::delete('delete/{product}', 'destroy')->name('destroy')->middleware('can:delete_products');
        Route::post('/import', 'import')->name('import')->middleware('can:create_products');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete')->middleware('can:delete_products');
        Route::get('/restore', 'restore_product')->name('restoreProduct')->middleware('can:delete_products');
        Route::patch('/{id}/restore', 'restore')->name('restore')->middleware('can:delete_products');
        Route::delete('/{id}/force-delete', 'forceDelete')->name('forceDelete')->middleware('can:delete_products');
    });
    Route::get('barcode-print', [\App\Http\Controllers\Admin\BarcodeController::class, 'index'])
        ->name('barcode-print')->middleware('can:view_products');

    Route::prefix('supplier')->name('supplier.')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_suppliers');
        Route::post('store', 'store')->name('store')->middleware('can:create_suppliers');
        Route::get('edit/{supplier}', 'edit')->name('edit')->middleware('can:edit_suppliers');
        Route::put('update/{supplier}', 'update')->name('update')->middleware('can:edit_suppliers');
        Route::delete('delete/{supplier}', 'destroy')->name('destroy')->middleware('can:delete_suppliers');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete')->middleware('can:delete_suppliers');
    });

    Route::prefix('purchase')->name('purchase.')->controller(PurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_purchases');
        Route::get('create', 'create')->name('create')->middleware('can:create_purchases');
        Route::post('store', 'store')->name('store')->middleware('can:create_purchases');
        Route::get('edit/{purchase}', 'edit')->name('edit')->middleware('can:edit_purchases');
        Route::put('update/{purchase}', 'update')->name('update')->middleware('can:edit_purchases');
        Route::get('/restore', 'restore_trashed')->name('restorePurchase')->middleware('can:view_purchases');
        Route::patch('/{id}/restore', 'restore')->name('restore')->middleware('can:edit_purchases');
        Route::delete('destroy/{purchase}', 'destroy')->name('destroy')->middleware('can:delete_purchases');
        Route::delete('delete/{purchase}', 'forceDelete')->name('forceDelete')->middleware('can:delete_purchases');
    });

    Route::prefix('customer')->name('customer.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_customers');
        Route::post('store', 'store')->name('store')->middleware('can:create_customers');
        Route::get('edit/{customer}', 'edit')->name('edit')->middleware('can:edit_customers');
        Route::put('update/{customer}', 'update')->name('update')->middleware('can:edit_customers');
        Route::delete('delete/{customer}', 'destroy')->name('destroy')->middleware('can:delete_customers');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete')->middleware('can:delete_customers');
    });

    // The POS terminal itself is the day-to-day cashier screen, not one of
    // the admin CRUD modules in the permission list, so it stays available
    // to any authenticated admin (same as Dashboard) and is only gated by
    // 'adminauth' above.
    Route::prefix('pos')->name('pos.')->controller(PosController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('search-products', 'searchProducts')->name('search-products');
        Route::get('search-barcode', 'searchByBarcode')->name('search-barcode');
        Route::get('search-customers', 'searchCustomers')->name('search-customers');
        Route::post('store-customer', 'storeCustomer')->name('store-customer');
        Route::post('calculate-totals', 'calculateTotals')->name('calculate-totals');
        Route::post('checkout', 'checkout')->name('checkout');
        Route::post('hold', 'hold')->name('hold');
        Route::get('held-orders', 'heldOrders')->name('held-orders');
        Route::get('held-orders/{id}/resume', 'resumeHeldOrder')->name('held-orders.resume');
        Route::delete('held-orders/{id}', 'deleteHeldOrder')->name('held-orders.delete');
        Route::get('recent-sales', 'recentSales')->name('recent-sales');
        Route::get('receipt/{id}', 'receipt')->name('receipt');
    });

    Route::prefix('sales')->name('sales.')->controller(SalesController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_sales');
        Route::get('{id}', 'show')->name('show')->middleware('can:view_sales');
        Route::patch('{id}/void', 'void')->name('void')->middleware('can:void_sales');
    });

    Route::prefix('returns')->name('returns.')->controller(ReturnController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_returns');
        Route::get('create', 'create')->name('create')->middleware('can:create_returns');
        Route::get('search-sale', 'searchSale')->name('search-sale')->middleware('can:create_returns');
        Route::post('store', 'store')->name('store')->middleware('can:create_returns');
        Route::get('{id}', 'show')->name('show')->middleware('can:view_returns');
    });

    // Held orders here mirror the sales module: viewing/resuming is a
    // "view_sales" action, discarding one is treated like voiding a sale.
    Route::prefix('held-orders')->name('held-orders.')->controller(HeldOrderController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_sales');
        Route::get('{id}/resume', 'resume')->name('resume')->middleware('can:view_sales');
        Route::delete('{id}', 'destroy')->name('destroy')->middleware('can:void_sales');
    });

    Route::prefix('expense-categories')->name('expense-categories.')->controller(ExpenseCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_expenses');
        Route::post('store', 'store')->name('store')->middleware('can:create_expenses');
        Route::put('update/{expense_category}', 'update')->name('update')->middleware('can:edit_expenses');
        Route::delete('delete/{expense_category}', 'destroy')->name('destroy')->middleware('can:delete_expenses');
    });

    Route::prefix('expenses')->name('expenses.')->controller(ExpenseController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_expenses');
        Route::get('create', 'create')->name('create')->middleware('can:create_expenses');
        Route::post('store', 'store')->name('store')->middleware('can:create_expenses');
        Route::get('edit/{expense}', 'edit')->name('edit')->middleware('can:edit_expenses');
        Route::put('update/{expense}', 'update')->name('update')->middleware('can:edit_expenses');
        Route::delete('delete/{expense}', 'destroy')->name('destroy')->middleware('can:delete_expenses');
    });

    Route::get('/restore-expenses', [ExpenseController::class, 'restore_trashed'])->name('expenses.restore')->middleware('can:view_expenses');
    Route::patch('/expenses/{id}/restore', [ExpenseController::class, 'restore'])->name('expenses.restore.action')->middleware('can:edit_expenses');
    Route::delete('/expenses/{id}/force-delete', [ExpenseController::class, 'forceDelete'])->name('expenses.forceDelete')->middleware('can:delete_expenses');

    Route::prefix('expense-reports')->name('expense-reports.')->controller(ExpenseReportController::class)->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:view_expenses');
        Route::get('trend-data', 'trendData')->name('trend-data')->middleware('can:view_expenses');
    });

    Route::prefix('reports')->name('reports.')->controller(ReportController::class)->middleware('can:view_reports')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('sales', 'sales')->name('sales');
        Route::get('purchases', 'purchases')->name('purchases');
        Route::get('inventory', 'inventory')->name('inventory');
        Route::get('stock-movement', 'stockMovement')->name('stock-movement');
        Route::get('profit-loss', 'profitLoss')->name('profit-loss');
        Route::get('day-end', 'dayEnd')->name('day-end');
        Route::get('customers', 'customers')->name('customers');
        Route::get('suppliers', 'suppliers')->name('suppliers');
        Route::get('returns', 'returns')->name('returns');
    });


    Route::prefix('sticky-notices')->name('sticky-notices.')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'sticky_notices')->name('sticky_notices');

    });

});
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
});

require __DIR__.'/auth.php';