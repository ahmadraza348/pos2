<?php

use App\Http\Controllers\Admin\{AdminUserController,AuthController, BrandController, CategoryController,CustomerController,PosController, DashboardController, ProductController, RoleController, UnitController, SupplierController};
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/hash', function () {
    return Hash::make('ahmadraza');
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
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pos', [PosController::class, 'pos'])->name('admin.pos');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('user')->controller(AdminUserController::class)->name('admin.user.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/add', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile/save/{id}', 'profile_update')->name('profile.update');
    });

    Route::prefix('roles')->controller(RoleController::class)->name('admin.roles.')->group(function () {
        Route::get('/', 'all_roles')->name('index');
        Route::post('store', 'add_roles')->name('store');
        Route::get('edit/{role}', 'edit_roles')->name('edit');
        Route::put('update/{role}', 'update_roles')->name('update');
        Route::delete('delete/{role}', 'delete_roles')->name('delete');
    });

    Route::prefix('permissions')->controller(RoleController::class)->name('admin.permissions.')->group(function () {
        Route::get('/', 'all_permissions')->name('index');
        Route::post('store', 'add_permissions')->name('store');
        Route::get('edit/{permission}', 'edit_permissions')->name('edit');
        Route::put('update/{permission}', 'update_permissions')->name('update');

        Route::delete('delete/{permission}', 'delete_permissions')->name('delete');
    });

    Route::prefix('roles-permissions')->controller(RoleController::class)->name('admin.roles_permissions.')->group(function () {
        Route::get('/', 'all_roles_permissions')->name('index');
        Route::get('/create', 'create_roles_permissions')->name('create');
        Route::post('store', 'store_roles_permissions')->name('store');
        Route::get('edit/{role_permission}', 'edit_roles_permissions')->name('edit');
        Route::put('update/{role_permission}', 'update_roles_permissions')->name('update');
        Route::delete('delete/{role_permission}', 'delete_roles_permissions')->name('delete');
    });

    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{category}', 'edit')->name('edit');
        Route::put('update/{category}', 'update')->name('update');
        Route::delete('delete/{category}', 'destroy')->name('destroy');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('import', 'import')->name('import');
    });

    Route::prefix('brand')->name('brand.')->controller(BrandController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{brand}', 'edit')->name('edit');
        Route::put('update/{brand}', 'update')->name('update');
        Route::delete('delete/{brand}', 'destroy')->name('destroy');
    });

    Route::prefix('unit')->name('unit.')->controller(UnitController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{unit}', 'edit')->name('edit');
        Route::put('update/{unit}', 'update')->name('update');
        Route::delete('delete/{unit}', 'destroy')->name('destroy');
    });

    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{product}', 'edit')->name('edit');
        Route::put('update/{product}', 'update')->name('update');
        Route::delete('delete/{product}', 'destroy')->name('destroy');
        Route::post('/import', 'import')->name('import');
        Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('/restore', 'restore_product')->name('restoreProduct');
        Route::patch('/{id}/restore', 'restore')->name('restore');
        Route::delete('/{id}/force-delete', 'forceDelete')->name('forceDelete');
    });

    Route::prefix('supplier')->name('supplier.')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{supplier}', 'edit')->name('edit');
        Route::put('update/{supplier}', 'update')->name('update');
        Route::delete('delete/{supplier}', 'destroy')->name('destroy');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });
  

    Route::prefix('purchase')->name('purchase.')->controller(PurchaseController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('edit/{purchase}', 'edit')->name('edit');
    Route::put('update/{purchase}', 'update')->name('update');
    Route::get('/restore',  'restore_trashed')->name('restorePurchase');
    Route::patch('/{id}/restore',  'restore')->name('restore');
    Route::delete('destroy/{purchase}', 'destroy')->name('destroy');
    Route::delete('delete/{purchase}', 'forceDelete')->name('forceDelete');
    });

  Route::prefix('customer')->name('customer.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{customer}', 'edit')->name('edit');
        Route::put('update/{customer}', 'update')->name('update');
        Route::delete('delete/{customer}', 'destroy')->name('destroy');
        Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });


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


    // Route::prefix('sales')->name('sales.')->group(function () {
    //     Route::get('/', [SalesController::class, 'index'])->name('index');
    //         Route::get('/details/{order}', [SalesController::class, 'details'])->name('detail');
    //         Route::post('/update-order-status/{order}', [SalesController::class, 'updateOrderStatus'])->name('update.status');

    //         Route::get('/pdf/{id}', [SalesController::class, 'download_pdf'])->name('download_pdf');
    //         Route::get('/print/{id}', [SalesController::class, 'print'])->name('print');
    //         Route::get('/sales/export', [SalesController::class, 'export'])->name('export');
    //     });

    // }

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
