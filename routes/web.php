<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/home', 'Frontend\User\HomeController@index')->name('home');
Route::get('/our-servces', 'Frontend\HomeController@ourServce')->name('our_servce');
Route::get('/contac-tus', 'Frontend\HomeController@contactUs')->name('contact_us');
Route::get('/about-us', 'Frontend\HomeController@aboutUs')->name('about_us');
// Landing Page
Route::get('/', 'Frontend\HomeController@index');
// Product Review
Route::get('/product/review/{id?}', 'Frontend\HomeController@productReview')->name('productReview');
// User login
Route::get('/login', 'Frontend\Auth\LoginController@showForm')->name('login');
Route::post('/login', 'Frontend\Auth\LoginController@login');
Route::get('/logout', 'Frontend\Auth\LoginController@logout')->name('logout');
// SignUp
Route::get('/sign-up', 'Frontend\Auth\LoginController@showForm')->name('signup');
Route::post('/sign-up', 'Frontend\Auth\LoginController@registration');
// Get All Districts
Route::post('districs', 'Frontend\User\UserController@getDistricts');
// Get All Upazilas
Route::post('upazilas', 'Frontend\User\UserController@getUpazilas');
// User Profile
Route::group(['prefix'=>'user'], function(){
	// Get User Wish List
	Route::post('/ajax/wishlist', 'Frontend\User\WishListController@getWishList');
	// Add To Wish List And Return Product ids
	Route::post('/ajax/add-to-wishlist', 'Frontend\User\WishListController@addToWishList');
	//  Wish List Product List
	Route::post('/ajax/wishlist-ids', 'Frontend\User\WishListController@wishListIds');
	// Delete Product From WishList
	Route::post('/ajax/delete-wishlist', 'Frontend\User\WishListController@deleteWishList');
	// User Cart
	Route::get('cart', 'Frontend\User\CartController@index');
	// Cart Checkoout
	Route::get('cart/checkout', 'Frontend\User\CartController@checkout');
	// Cart Submit
	Route::post('cart/submit', 'Frontend\User\OrderController@makeOrder');
	// Fetch All Order Of A User
	Route::post('all/order', 'Frontend\User\OrderController@getAllOrder');
	// Fetch sigle Order Of A User
	Route::post('get/order/{id?}', 'Frontend\User\OrderController@getOrder');
	// User Profile
	Route::post('profile/update', 'Frontend\User\UserController@profileUpdate');
	// Getting User Data
	Route::post('profile/get', 'Frontend\User\UserController@getUserData');
	//
	Route::get('my_order', 'Frontend\User\HomeController@index');
	Route::get('wishlist', 'Frontend\User\HomeController@index');
	Route::get('settings', 'Frontend\User\HomeController@index');

});

/*   
 * ===================
 *	Shop Routes
 * ===============
*/
Route::group(['prefix'=>'shop'], function(){
	// Index
	Route::get('/{slug?}', 'Frontend\ShopController@index')->name('shop');
	// Fetch Brand for Filter
	Route::post('/fetch/brand', 'Frontend\ShopController@brand');
	// Fetch Color for Filter
	Route::post('/fetch/color', 'Frontend\ShopController@color');
	// Fetch Size for Filter
	Route::post('/fetch/size', 'Frontend\ShopController@size');
	// Fetch Unit for Filter
	Route::post('/fetch/unit', 'Frontend\ShopController@unit');
	// Fetch Product of Shop
	Route::post('/fetch/product', 'Frontend\ShopController@product');
	// Fetch Searching Key
	Route::post('/fetch/searching/key', 'Frontend\ShopController@searchingKey');
	// Product Filter
	Route::post('/product/filter', 'Frontend\ShopController@productFilter');
	// Product Quick View
	Route::post('/product/quick-view', 'Frontend\ShopController@quickView');
	// Search bar query
	Route::post('/search', 'Frontend\ShopController@search');

});

/*  Admins 
 * ===================
 *	Login Routes
 * ===============
*/
Route::get('admin/logout', 	'Backend\Auth\RegistationController@logout')->name('admin.logout');
Route::get('admin/login', 	'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 	'Backend\Auth\LoginController@login')->name('admin.login');
// Admin
Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function(){
	/*
	 * ==================
	 *	Brand Route
	 * ================
	*/
	Route::group(['prefix'=>'brand'], function(){
		// Index Route
		Route::get('/', 'Backend\BrandController@index')->name('admin.brand');		
		// Brand List	
		Route::post('/all', 'Backend\BrandController@all');	
		// New SubCategory Create
		Route::post('/store', 'Backend\BrandController@store');
		// Brand Update
		Route::post('/update/{id}', 'Backend\BrandController@update');
		// Delete Brand
		Route::post('/delete/{id}', 'Backend\BrandController@delete');		

	});

	/*
	 * ==================
	 *	Category Route
	 * ================
	*/	
	Route::group(['prefix'=>'category'], function(){
		// Index Route
		Route::get('/', 'Backend\CategoryController@index')->name('admin.category');		
		// Category List	
		Route::post('/all', 'Backend\CategoryController@all');	
		Route::post('/all/img', 'Backend\CategoryController@allImg');	
		// New Category Create
		Route::post('/store', 'Backend\CategoryController@store');
		// Category Update
		Route::post('/update/{id}', 'Backend\CategoryController@update');
		// Delete Category
		Route::post('/delete/{id}', 'Backend\CategoryController@delete');	

	});

	/*
	 * ======================
	 *	SubCategory Route
	 * ===================
	*/
	Route::group(['prefix'=>'subcategory'], function(){
		// Index Route
		Route::get('/', 'Backend\SubCategoryController@index')->name('admin.subcategory');		
		// SubCategory List	
		Route::post('/all', 'Backend\SubCategoryController@all');	
		// New SubCategory Create
		Route::post('/store', 'Backend\SubCategoryController@store');
		// SubCategory Update
		Route::post('/update/{id}', 'Backend\SubCategoryController@update');
		// Delete SubCategory
		Route::post('/delete/{id}', 'Backend\SubCategoryController@delete');	

	});

	/*
	 * ======================
	 *	SubSubCategory Route
	 * ===================
	*/
	Route::group(['prefix'=>'subsubcategory'], function(){
		// Index Route
		Route::get('/', 'Backend\SubSubCategoryController@index')->name('admin.subsubcategory');		
		// SubSubCategory List	
		Route::post('/all', 'Backend\SubSubCategoryController@all');	
		// New SubSubCategory Create
		Route::post('/store', 'Backend\SubSubCategoryController@store');
		// SubSubCategory Update
		Route::post('/update/{id}', 'Backend\SubSubCategoryController@update');
		// Delete SubSubCategory
		Route::delete('/delete/{id}', 'Backend\SubSubCategoryController@delete');

	});

	/*
	 * ==================
	 *	Color Route
	 * ================
	*/
	Route::group(['prefix'=>'color'], function(){
		// Index Route
		Route::get('/', 'Backend\ColorController@index')->name('admin.color');		
		// Color List	
		Route::post('/all', 'Backend\ColorController@all');	
		// New Color Create
		Route::post('/store', 'Backend\ColorController@store');
		// Color Update
		Route::post('/update/{id}', 'Backend\ColorController@update');
		// Delete Color
		Route::post('/delete/{id}', 'Backend\ColorController@delete');	

	});	

	/*
	 * ==================
	 *	Size Route
	 * ================
	*/	
	Route::group(['prefix'=>'size'], function(){
		// Index Route
		Route::get('/', 'Backend\SizeController@index')->name('admin.size');		
		// size List	
		Route::post('/all', 'Backend\SizeController@all');	
		// New size Create
		Route::post('/store', 'Backend\SizeController@store');
		// size Update
		Route::post('/update/{id}', 'Backend\SizeController@update');
		// Delete size
		Route::post('/delete/{id}', 'Backend\SizeController@delete');	

	});

	/*
	 * ==================
	 *	Unit Route
	 * ================
	*/	
	Route::group(['prefix'=>'unit'], function(){
		// Index Route
		Route::get('/', 'Backend\UnitController@index')->name('admin.unit');		
		// SubCategory List	
		Route::post('/all', 'Backend\UnitController@all');	
		// New SubCategory Create
		Route::post('/store', 'Backend\UnitController@store');
		// SubCategory Update
		Route::post('/update/{id}', 'Backend\UnitController@update');
		// Delete SubCategory
		Route::post('/delete/{id}', 'Backend\UnitController@delete');	

	});

	/*
	 * ==================
	 *	Slider Route
	 * ================
	*/
	Route::group(['prefix'=>'slider'], function(){
		// Slider Index
		Route::get('/', 'Backend\SliderController@index')->name('admin.slider');
		// All Slider
		Route::get('/all/data', 'Backend\SliderController@list');
		// Add		
		Route::post('/store', 'Backend\SliderController@store');	
		// Update
		Route::post('/update/{id?}', 'Backend\SliderController@update');
		// Delete
		Route::get('/delete/{id}', 'Backend\SliderController@delete');

	});

	/*
	 * ======================
	 *	Products Route
	 * ===================
	*/
	Route::group(['prefix'=>'product'], function(){
		// Product List
		Route::get('/list', 'Backend\ProductController@index')->name('admin.product.list');	
		// Get All Product
		Route::post('/all', 'Backend\ProductController@getAll');	
		// Product Review
		Route::get('/view/{id}', 'Backend\ProductController@view')->name('admin.product.view');	
		// Product Edit
		Route::get('/edit/{id}', 'Backend\ProductController@edit')->name('admin.product.edit');	
		Route::match(['GET', 'POST'], '/find/{id}', 'Backend\ProductController@find');	
		// New Product Create
		Route::get('/add', 'Backend\ProductController@add')->name('admin.product.add');	
		// Product Store
		Route::post('/store', 'Backend\ProductController@store');
		// Product Update
		Route::post('/update/{id}', 'Backend\ProductController@update');
		// Product Store
		Route::post('/trash', 'Backend\ProductController@trash');
		// Delete Image
		Route::post('/image/delete/{id}', 'Backend\ProductController@imgDelete');

	});
	/*
	 * ========================
	 *	Site Setting Routes
	 * =====================
	*/
	Route::get('/','Backend\Admin\AdminController@index')->name('admin.dashboard');
	Route::get('/profile','Backend\Admin\ProfileController@index')->name('admin.profile');
	Route::post('/profile/fetch','Backend\Admin\ProfileController@fetch');
	Route::post('/profile/update','Backend\Admin\ProfileController@update');
	//
	Route::get('/settings','Backend\Admin\SettingController@index')->name('admin.settings');
	Route::post('/settings','Backend\Admin\SettingController@axios');
	Route::post('/settings/getData','Backend\Admin\SettingController@getData');

	/*
	 * =================
	 *	Info Routes
	 * ==============
	*/
	Route::get('/list','Backend\Admin\AdminController@list')->name('admin.all');
	// Add
	Route::get('/add', 'Backend\Admin\AdminController@add')->name('admin.add');
	Route::post('/add','Backend\Admin\AdminController@store')->name('admin.store');
	// Edit
	Route::get('/edit/{id}','Backend\Admin\AdminController@edit')->name('admin.edit');
	Route::post('/update/{id}','Backend\Admin\AdminController@update')->name('admin.update');
	// View
	Route::get('/view/{id}','Backend\Admin\AdminController@view')->name('admin.view');
	// Delete Or Deactive
	Route::get('/delete/{id}', 'Backend\Admin\AdminController@delete')->name('admin.delete');
	Route::get('/deactive/{id}','Backend\Admin\AdminController@deactive')->name('admin.deactive');
	
	/*
	 * ====================
	 *	Privilege Routes
	 * ==================
	*/
	Route::get('/privilege', 'Backend\Developer\PrivilegeController@previlege')->name('admin.privilege');
	Route::get('/privilege/{user_id?}', 'Backend\Developer\AjaxController@getUserPrivilege')->name('admin.getUser.privilege');
	Route::post('/privilege', 'Backend\Developer\AjaxController@setUserPrivilege')->name('admin.setUser.privilege');
	/*
	 * ==================
	 *	Our Services
	 * ===============
	*/
	Route::group(['prefix'=>'services'], function(){
		// List of Services
		Route::get('list', 'Backend\ServiceController@index')->name('admin.services.list');
		// New Service Store
		Route::match(['GET', 'POST'], 'add', 'Backend\ServiceController@add')->name('admin.services.add');
		// Service Edit
		Route::match(['GET', 'POST'], 'edit/{id}', 'Backend\ServiceController@edit')->name('admin.services.edit');
		// Service View
		Route::get('view/{id}', 'Backend\ServiceController@view')->name('admin.services.view');
		// Service Delete
		Route::get('delete/{id}', 'Backend\ServiceController@delete')->name('admin.services.delete');
	});


	/*
	 * ==================
	 *	Order
	 * ===============
	*/
	Route::get('order', 'Backend\OrderController@index')->name('admin.order');
	Route::post('order/all', 'Backend\OrderController@allOrders');
	Route::post('order/details', 'Backend\OrderController@order');
	Route::post('order/status', 'Backend\OrderController@changeStatus');
});

// For Frontend Api
Route::group(['prefix'=>'api'], function(){
	// Fetch Category With Skip and Take
	Route::post('category', 'API\CategoryController@limit');
	// Fetch Product With Skip and Take
	Route::post('product', 'API\ProductController@limit');
});

/*
 * ===================
 *	This Route Only
 *	For Developer
 *	Tools
 * =================
*/

Route::group(['prefix' => 'developer', 'middleware'=>'admin'], function()
{
	route::get('/index', 'Backend\Developer\DeveloperController@index')->name('developer');
	route::get('/menu/add', 'Backend\Developer\DeveloperController@MenuAdd')->name('developer.menu.add');
	route::post('/menu/store', 'Backend\Developer\DeveloperController@MenuStore')->name('developer.menu.store');
	// 
	route::post('/all/menu/submenu/', 'Backend\Developer\AjaxController@MenuSubmenu')->name('deleveoper.menu.fetch');
	route::post('/fetch/sigle/menu/', 'Backend\Developer\AjaxController@SigleMenu')->name('deleveoper.sigle.menu.fetch');
	//
	route::post('/all/menu/submenu/store', 'Backend\Developer\AjaxController@MenuSubmenuStore')->name('developer.menu.store');
	//
	route::get('/all/menu/submenu/edit/{type}/{id}', 'Backend\Developer\DeveloperController@MenuEdit')->name('developer.menu.edit');
	route::post('/all/menu/submenu/update', 'Backend\Developer\AjaxController@MenuUpdate')->name('developer.menu.update');
	//
	route::get('/all/menu/submenu/delete/{type}/{id}', 'Backend\Developer\DeveloperController@MenuDelete')->name('developer.menu.delete');
	// Language
	route::get('/menu/language', 'Backend\Developer\DeveloperController@language')->name('developer.language');
	route::post('/menu/language', 'Backend\Developer\DeveloperController@languageStore')->name('developer.language.store');
	//
	route::get('/lang/files/{dir?}', 'Backend\Developer\DeveloperController@getAllLanFile')->name('developer.lang.files');
});


// Localization
route::get('/localization/{len}', function ($len){
	if (! in_array($len, ['en', 'bn'])) {
        abort(400);
    }
	Session::put('locale', $len);
	return redirect()->back();
})->name('localization');