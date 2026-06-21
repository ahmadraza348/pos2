<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributevalueController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAttrController;
use App\Http\Controllers\Admin\ProductColorsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\UnitController;
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
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Admin User Routes
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

    // Roles And Permissions Routes start here
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
});

Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulk-delete');
Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
Route::get('/restore-products', [ProductController::class, 'restore_product'])->name('product.restore');
Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');


    // Route::prefix('attribute')->name('attribute.')->controller(AttributeController::class)->group(function () {

    //     Route::get('/', 'index')->name('index');
    //         Route::get('create', 'create')->name('create');
    //         Route::post('store', 'store')->name('store');
    //         Route::get('edit/{attribute}', 'edit')->name('edit');
    //         Route::post('update/{attribute}', 'update')->name('update');
    //     Route::delete('delete/{attribute}', 'destroy')->name('destroy');
    // });

    // Route::prefix('colors')->name('colors.')->controller(ProductColorsController::class)->group(function () {
    //     Route::get('/', 'index')->name('index');

    //         Route::get('/create', 'create')->name('create');
    //         Route::post('/store', 'store')->name('store');
    //         Route::get('/edit/{color}', 'edit')->name('edit');
    //         Route::post('/update/{color}', 'update')->name('update');
    //     Route::delete('/destroy/{color}', 'destroy')->name('destroy');
    // });

    // Route::prefix('attributevalue')->name('attributevalue.')->controller(AttributevalueController::class)->group(function () {

    //     Route::get('/', 'index')->name('index');
    //         Route::get('create', 'create')->name('create');
    //         Route::post('store', 'store')->name('store');
    //         Route::get('edit/{attributevalue}', 'edit')->name('edit');
    //         Route::put('update/{attributevalue}', 'update')->name('update');
    //     Route::delete('delete/{attributevalue}', 'destroy')->name('destroy');
    // });

    // Route::prefix('pro-attributes')->name('admin.pro.attribute.')->group(function () {
    //     Route::get('/add/{id}', [ProductAttrController::class, 'add_pro_attr'])->name('index');
    //     Route::post('/store', [ProductAttrController::class, 'store_pro_attr'])->name('store');
    //     Route::get('/fetch/{id}', [ProductAttrController::class, 'fetch_pro_attr'])->name('fetch');
    //     Route::post('/update/{id}', [ProductAttrController::class, 'update_pro_attr'])->name('update');
    //     Route::delete('/delete/{id}', [ProductAttrController::class, 'delete_pro_attr'])->name('delete');
    // });

    // Route::prefix('coupons')->name('coupons.')->group(function () {
    //     Route::get('/', [CouponController::class, 'index'])->name('index');
    //     Route::post('/store', [CouponController::class, 'store'])->name('store');
    //     Route::get('/edit/{coupon}', [CouponController::class, 'edit'])->name('edit');
    //     Route::put('/update/{coupon}', [CouponController::class, 'update'])->name('update');
    //     Route::delete('/destroy/{coupon}', [CouponController::class, 'destroy'])->name('delete');
    // });

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

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
