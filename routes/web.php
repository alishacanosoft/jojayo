<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Resources\Json\Resource;

Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});

Route::get('/', 'FrontController@index')->name('home');

Route::get('/login', function () {
    if (Auth::user() && Auth::user()->roles == 'customers') {
        return redirect('/dashboard');
    } else {
        return view('frontend.pages.login');
    }
})->name('signinform');

Route::get('/seller/login', 'FrontController@vendorLogin')->name('vendorLogin');

Route::get('/signup', function () {
    if (Auth::user()->roles == 'customers') {
        return redirect('/dashboard');
    } else {
        return view('frontend.pages.signup');
    }
})->name('signupform');

Route::post('/order/update-status', 'OrderController@updateStatus')->name('order_status');

Route::patch('/password', 'UserController@password')->name('users.password');

Route::post('/orders/update-status', 'OrderController@');

Route::get('/shop/{slug}', 'FrontController@singleProduct')->name('single-product');

Route::get('/index', function () {
    return view('frontend.pages.index1');
});
//Route::get('/quick/{slug}', 'ProductController@quickView')->name('quickview');

Route::get('blogs/search/', 'FrontController@searchBlog')->name('searchBlog');

Route::get('blogs/{slug}','FrontController@blogSingle');
  

Route::get('/blogs/categories/{slug}', 'FrontController@blogCategories');
Route::get('/blogs', 'FrontController@blogs');
Route::get('/shop', 'FrontController@shop');

Route::get('/flash-sales', 'FrontController@flash');
Route::get('/categories', function () {
    return redirect('/shop');
});

Route::get('/sell-on-jojayo', 'FrontController@becomeVendor');
Route::get('/vendor/{vendor}', 'FrontController@vendorProduct')->name('vendor.store');

Route::get('/contact', 'ContactController@contact');


Route::get('/categories/{name}', 'FrontController@categories')->name('categories');
Route::get('/categories/{prime_cat}/{name}', 'FrontController@categories')->name('categories.sec');
Route::get('/shopping-cart', function () {
    return view('frontend.pages.shopping-cart');
});
Route::get('/checkout', function () {
    return view('frontend.pages.checkout');
});
// Route::get('/review', function () {
//     return view('frontend.pages.checkout-review');
// });

Route::get('/forgot-password', function () {
    return view('frontend.pages.password');
});
Auth::routes();

Route::get('/get-city/{id}', 'FrontController@getCity');

Route::get('/get-area/{id}', 'FrontController@getArea');

//facebook and google login
Route::get('login/{service}', 'UserController@redirectToProvider');
Route::get('login/{service}/callback', 'UserController@handleProviderCallback');


// Admin Routes

Route::delete('/product-delete', 'ProductController@ajaxDestroy')->name('ajax.products');
Route::delete('/categories-delete', 'CategoryController@ajaxDestroy')->name('ajax.categories');
Route::delete('/users-delete', 'UserController@ajaxDestroy')->name('ajax.users');

Route::get('/colors', 'ColorController@getColors')->name('colors');

Route::post('/sizes', 'SizeController@getSizes')->name('getsize');

Route::post('/recent/sizes', 'SizeController@getRecent')->name('getrecent');

Route::post('/check-warranty', 'FrontController@warranty')->name('warranty_check');

Route::post('/login', 'UserController@login')->name('login');

Route::post('/customer/login', 'UserController@CustomerLogin')->name('customerlogin');

Route::post('/customer/signup', 'UserController@customerSignUp')->name('customerSignUp');

Route::patch('user-edit/{id}', 'UserController@UpdateUser')->name('update_user');

Route::get('/cart', function () {
    return view('frontend.pages.cart');
});

Route::get('/review', 'FrontController@review')->middleware('auth')->name('review');


Route::get('/esewa', 'FrontController@eSewa')->name('eSewa');

Route::resource('cart', 'CartController');

Route::get('/clear-cart', 'CartController@destroyCart')->name('destroyCart');

Route::patch('/update-cart/{id}', 'CartController@updateCart')->name('update.cart');

Route::get('/quick-view/{id}', 'ProductController@quickview')->name('quick');

Route::get('/checkout/payment/esewa', [
    'name' => 'eSewa Checkout Payment',
    'as' => 'checkout.payment.esewa',
    'uses' => 'EsewaController@checkout',
]);

Route::get('/checkout/payment/success/esewa', [
    'name' => 'eSewa Checkout Successful Payment',
    'as' => 'checkout.payment.success.esewa',
    'uses' => 'EsewaController@success',
]);

Route::post('/checkout/payment/esewa/process', [
    'name' => 'eSewa Checkout Payment',
    'as' => 'checkout.payment.esewa.process',
    'uses' => 'EsewaController@payment',
]);

Route::get('/checkout/payment/{order}/esewa/completed', [
    'name' => 'eSewa Payment Completed',
    'as' => 'checkout.payment.esewa.completed',
    'uses' => 'EsewaController@completed',
]);

Route::get('/checkout/payment/{order}/esewa/failed', [
    'name' => 'eSewa Payment Failed',
    'as' => 'checkout.payment.esewa.failed',
    'uses' => 'EsewaController@failed',
]);

// senstive
Route::post('/product-available-size/{id}', 'ProductSizeController@GetAvailableSize');

Route::get('/product-available-size/{id}', 'ProductSizeController@ProductAvailSize');

Route::post('get-stock/', 'ProductSizeController@getstock')->name('getstock');

Route::get('user/address/{id}', 'AddressBookController@userAddress')->name('user.address');

Route::get('/auth/get_cart_content/', 'FrontController@cartContent')->name('cart.content');

Route::get('/auth/get_cart_count/', 'CartController@cartCount')->name('cart.count');

Route::get('/wish/get_wishlist_count/', 'WishlistController@wishlistCount')->name('wish.count');

Route::resource('users', 'UserController');

Route::resource('wish', 'WishlistController');

Route::delete('/wish/remove/{id}', 'WishlistController@remove')->name('wish.remove');

Route::group(['prefix' => 'auth', 'middleware' => ['auth']], function () {

    Route::get('/expenses', 'ProductExpenseController@index')->name('record-list');

    Route::get('/dashboard','AdminController@index');

    Route::get('/media', function () {
        return view('admin.pages.fileupload');
    });

    Route::get('/expense-edit/{id}', 'ProductExpenseController@edit')->name('expense_edit');

    Route::match(['put', 'patch'], '/expense-update/{id}', 'ProductExpenseController@update')->name('expense_update');

    Route::resource('sales', 'SalesController');

    Route::post('/product-available-color/{id}', 'ProductSizeController@GetAvailableColor');

    Route::post('/admin/get-account/', 'AccountController@getAccounts')->name('getaccounts');

    Route::delete('/product-images-delete', 'ProductImageController@destroyProductImages')->name('delete_product_images');

    Route::delete('/product-sizes-delete', 'ProductSizeController@destroyProductSizes')->name('delete_product_sizes');

    // categories
    Route::get('parentcategories', 'ProductCategoryController@getParentController')->name('parentCategories');

    Route::get('postparentcategories', 'CategoryController@getParentController')->name('postparentCategories');

    Route::get('last-post', 'CategoryController@lastData')->name('lastPost');

    Route::get('last', 'ProductCategoryController@lastData')->name('lastData');

    Route::get('/categoryedit/{slug}', 'ProductCategoryController@editCategory')->name('editCategory');

    Route::get('/postcategoryedit/{slug}', 'CategoryController@editPostCategory')->name('editPostCategory');

    Route::get('/brandedit/{slug}', 'BrandController@editBrand')->name('editBrand');

    Route::get('products/trash', 'ProductController@trash')->name('products.trash');
    Route::patch('products/{product_id}/restore', 'ProductController@restore')->name('products.restore');

    Route::resource('products', 'ProductController');

    Route::resource('brands', 'BrandController');

    Route::resource('sizes', 'SizeController');

    Route::resource('orders', 'OrderController');

    Route::resource('product_categories', 'ProductCategoryController');

    Route::get('vendors/{id}/percent', 'UserController@percent')->name('vendors.percent');

    Route::get('vendors/{id}/percent/edit', 'UserController@percentEdit')->name('vendors.percent.edit');

    Route::post('vendors/', 'UserController@storePercent')->name('user.percent');

    Route::get('users/{user_id}/info','UserController@userInfo')->name('user.info');

    Route::resource('blogs', 'BlogController');

    Route::resource('attributes', 'AttributeController');

    Route::resource('payments', 'PaymentController');

    Route::resource('category', 'CategoryController');

    Route::resource('colors', 'ColorController');

    Route::resource('ads', 'AdsController');

    Route::resource('sliders', 'SliderController');

    Route::resource('page', 'PageController');

    Route::resource('brands', 'BrandController');

    Route::get('brandlast', 'BrandController@brandLastData')->name('brandLastData');

    Route::resource('sizes', 'SizeController');

    Route::resource('accounts', 'AccountController');

    Route::resource('areas', 'AreaController');

    Route::resource('cities', 'CityController');

    Route::resource('primary_categories', 'PrimaryCategoryController');

    Route::resource('secondary_categories', 'SecondaryCategoryController');

    Route::resource('settings', 'SensitiveDataController')->middleware('admin');

    Route::get('/primary_last', 'PrimaryCategoryController@lastData')->name('PrimarylastData');

    Route::get('/primary_category_edit/{slug}', 'PrimaryCategoryController@editPrimaryCategory')->name('editPrimaryCategory');

    Route::get('primarycategories', 'PrimaryCategoryController@getPrimaryController')->name('primaryCategories');

    Route::get('/secondary_last', 'SecondaryCategoryController@lastData')->name('SecondarylastData');

    Route::get('/secondary_category_edit/{slug}', 'SecondaryCategoryController@editSecondaryCategory')->name('editSecondaryCategory');

    Route::get('last-payment', 'PaymentController@lastPaymentData')->name('lastPaymentData');

    Route::get('/get_category_brand/{id}', 'FrontController@getCategoryBrand');

    Route::get('/get_attribute/{id}', 'CategoryAttributeController@getAttribute');

    Route::get('/get_attribute_data/{id}', 'CategoryAttributeController@getAttributeData');

    Route::get('/get_attribute_value/{id}', 'CategoryAttributeController@getAttributeValue');

    Route::post('/get_similar', 'ProductController@getSimilar')->name('getSimilar');

    Route::resource('office_category', 'OfficeCategoryController');

    Route::resource('office_voucher', 'OfficeVouchersController');

    Route::get('ajaxRequest', 'AjaxController@ajaxRequest');
    Route::get('ajaxRequest', 'AjaxController@ajaxRequestGet')->name('ajaxRequest.post');

    Route::get('order-details', 'OrderController@orderDetail')->name('orderDetail');

    Route::get('/get-cities/{id}', 'CityController@getCity');
    Route::get('/get-areas/{id}', 'AreaController@getArea');

    Route::get('ajaxRequest/products', 'AjaxController@ajaxProductsget')->name('ajaxRequest.products');
    Route::get('ajaxRequest/orders', 'AjaxController@ajaxOrdersget')->name('ajaxRequest.orders');
    Route::get('ajaxRequest/multiorders', 'AjaxController@ajaxMultiOrdersget')->name('ajaxRequest.multiorder');
    Route::get('/ajaxRequest/{id}/pdfExport', 'AjaxController@getPdf')->name('ajaxRequest.getPdf');
    Route::get('ajaxRequest/orderDetail', 'AjaxController@ajaxOrderDetail')->name('ajaxRequest.orderDetail');
    Route::post('/ajaxRequest/monthlyExport', 'AjaxController@getmonthPdf')->name('ajaxRequest.getmonthPdf');
    
    Route::post('/get/transaction/type', 'FrontController@transactionType')->name('transaction.detail');
    //Finanace
    Route::get('/finance/account-statement', 'FrontController@statement');
    Route::get('/get_vendor_data/{id}', 'FrontController@getVendorData');
    Route::get('/get_statement/{id}/{date}', 'FrontController@getStatement');
    Route::post('/print_finance', 'FrontController@printFinance')->name('printFinance');
    Route::get('get/transaction/detail', 'FrontController@transaction')->name('transaction');
    Route::post('get/transaction/detail', 'FrontController@updateTransaction')->name('updateTransaction');

    Route::get('/vendor-product/{id}', 'FrontController@getVendorProduct')->name('getVendorProduct');    
});

Route::group(['middleware' => ['auth', 'customers']], function () {
    Route::get('/dashboard', function () {
        return view('frontend.pages.dashboard');
    });

    Route::get('/account-information', function () {
        return view('frontend.pages.account-information');
    });

    Route::get('/add-address', 'FrontController@addressBookAdd')->name('addressList');

    Route::get('/address-book', 'AddressBookController@index');

    Route::resource('address', 'AddressBookController');

    Route::get('/shipping', 'FrontController@shipping');

});

Route::group(['prefix' => 'vendor', 'middleware' => ['auth', 'vendor']], function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.index');
    });
});

Route::group(['prefix' => 'employee', 'middleware' => ['auth', 'employee']], function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.index');
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::get('search', 'FrontController@searchProduct')->name('searchProduct');
Route::post('getproductsList', "FrontController@getProduct")->name('searchProductAjax');

Route::get('sendsms', 'FrontController@sendSms');

Route::get('ipsconnect', 'FrontController@ipsconnect');


Route::get('/checkout/payment/connectips', [
    'name' => 'connectips Checkout Payment',
    'as' => 'checkout.payment.connectips',
    'uses' => 'ConnectIpsController@checkout',
]);

Route::get('/checkout/payment/success/connectips', [
    'name' => 'connectips Checkout Successful Payment',
    'as' => 'checkout.payment.success.connectips',
    'uses' => 'ConnectIpsController@success',
]);
Route::post('/checkout/payment/connectips/process', [
    'name' => 'connectips Checkout Payment',
    'as' => 'checkout.payment.connectips.process',
    'uses' => 'ConnectIpsController@payment',
]);

Route::get('/checkout/payment/connectips/success', [
    'name' => 'connectips Payment Completed',
    'as' => 'checkout.payment.connectips.completed',
    'uses' => 'ConnectIpsController@success',
]);

Route::get('/checkout/payment/{order}/connectips/success', [
    'name' => 'connectips Payment Completed',
    'as' => 'checkout.payment.connectips.completed',
    'uses' => 'ConnectIpsController@completed',
]);

Route::get('/checkout/payment/{order}/failed', [
    'name' => 'connectips Payment Failed',
    'as' => 'checkout.payment.connectips.failed',
    'uses' => 'ConnectIpsController@failed',
]);

Route::get('/my-orders', 'OrderController@myOrders');

Route::get('/order-tracking', function () {
    return view('frontend.pages.order-tracking');
});

Route::get('/get/order-tracking', 'OrderController@tracking')->name('tracking');

Route::get('/my-wishlist', 'FrontController@wishlist');

Route::get('/{slug}', 'FrontController@page')->name('pageDetail');
