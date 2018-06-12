<?php
use Illuminate\Http\Request;
use App\Api\Provider as Api;

Route::group(['middleware' => ['api']], function () {
    Route::any('api/{action}', function($action, Request $request) {
      $this->api = new Api;
      switch ($action) {
        case 'syncGetUsers':
          $this->api->syncGetUsers();
        break;
        case 'syncSendOrders':
          $this->api->syncSendOrders();
        break;
        case 'syncGetOrders':
          $this->api->syncGetOrders();
        break;
        case 'syncGetProducts':
          $this->api->syncGetProducts();
        break;
        case 'syncGetProducers':
          $this->api->syncGetProducers();
        break;
        case 'syncGetUserDiscounts':
          $this->api->syncGetUserDiscounts([1766]);
        break;
        case 'syncGetDiscounts':
          $this->api->syncGetDiscounts();
        break;
        case 'syncGetDiscountGroups':
          $this->api->syncGetDiscountGroups();
        break;
        case 'syncGetDiscountGroupsByProducer':
          $this->api->syncGetDiscountGroupsByProducer();
        break;
        case 'syncGetUsersInvoices':
          $this->api->syncGetUsersInvoices();
        break;
        case 'syncGetUsersPayments':
          $this->api->syncGetUsersPayments();
        break;
        case 'flushClients':
          $this->api->flushClients();
        break;        
        case 'flushOrders':
          $this->api->flushOrders();
        break;
        case 'storage':
          return $this->api->storeFiles($request);
        break;
        case 'addMessage':
          return $this->api->storeMessage($request);
        break;
        case 'cron':
          return view('crontabs');
        break;
        default:
          return $action . ' not allowed';
        break;
      }
      // $this->api->apiSearchGetList(['51470142615']);
    });
});

Route::group(['middleware' => ['ajax', 'multilanguageforajax']], function () {
    Route::post('ajax', ['as'=>'ajax', 'uses'=>'AjaxController@index'])->middleware('ajax');
    Route::get('ajax', ['as'=>'ajax', 'uses'=>'AjaxController@index'])->middleware('ajax');
    Route::get('get_captcha', ['as'=>'ajax', 'uses'=>'AjaxController@captcha'])->middleware('ajax');
    Route::get('logout', ['as'=>'ajax', 'uses'=>'AjaxController@logout'])->middleware('ajax');
});

Route::group(['middleware' => ['web', 'multilanguage']], function () {
    Route::get('/', ['as'=>'home', 'uses'=>'AppController@home']);
    Route::get('404', ['as'=>'404', 'uses'=>'AppController@notfound']);
    Route::get('terms', ['as'=>'terms', 'uses'=>'AppController@terms']);
    Route::get('legal', ['as'=>'legal', 'uses'=>'AppController@legal']);
    Route::get('privacy', ['as'=>'privacy', 'uses'=>'AppController@privacy']);
    Route::get('returns', ['as'=>'returns', 'uses'=>'AppController@returns']);
    Route::get('shipping', ['as'=>'shipping', 'uses'=>'AppController@shipping']);
    Route::get('secure', ['as'=>'secure', 'uses'=>'AppController@secure']);
    Route::get('guarantee&warranty', ['as'=>'guarantee', 'uses'=>'AppController@guarantee']);
    Route::get('profile/settings', ['as'=>'profile', 'uses'=>'AppController@settings']);
    Route::get('profile/balance', ['as'=>'balance', 'uses'=>'AppController@balance']);
    Route::get('profile', function() { return redirect()->route('profile'); });
    Route::get('profile/orders', ['as'=>'orders', 'uses'=>'AppController@myorders']);
    Route::get('profile/orders/{order}', ['as'=>'orders', 'uses'=>'AppController@myorder']);
    Route::get('profile/security', ['as'=>'security', 'uses'=>'AppController@security']);
    Route::get('profile/pricelists', ['as'=>'pricelists', 'uses'=>'AppController@pricelists']);
    Route::get('profile/pricelists/{file}', ['as'=>'pricelists', 'uses'=>'AppController@price']);
    Route::get('profile/payments', ['as'=>'payments', 'uses'=>'AppController@payments']);
    Route::get('cart', ['as'=>'cart', 'uses'=>'AppController@cart']);
    Route::get('parts', ['as'=>'parts', 'uses'=>'AppController@parts']);
    Route::get('parts/{mf}', ['as'=>'parts', 'uses'=>'AppController@brand']);
    Route::get('prices', ['as'=>'prices', 'uses'=>'AppController@prices']);
    Route::get('prices/{file}', ['as'=>'prices', 'uses'=>'AppController@price']);
    Route::get('products', ['as'=>'products', 'uses'=>'AppController@products']);
    Route::get('products/{slug}', ['as'=>'product', 'uses'=>'AppController@product']);
    Route::get('news', ['as'=>'posts', 'uses'=>'AppController@posts']);
    Route::get('news/{slug}', ['as'=>'post', 'uses'=>'AppController@post']);
    Route::get('about/whyus', ['as'=>'whyus', 'uses'=>'AppController@whyus']);
    Route::get('about/profile', ['as'=>'companyprofile', 'uses'=>'AppController@companyprofile']);
    Route::get('about/gallery', ['as'=>'gallery', 'uses'=>'AppController@gallery']);
    Route::get('about/join', ['as'=>'joinus', 'uses'=>'AppController@joinus']);
    Route::get('about/benefits', ['as'=>'benefits', 'uses'=>'AppController@benefits']);
    Route::get('about/team', ['as'=>'team', 'uses'=>'AppController@team']);
    Route::get('about/certificates', ['as'=>'team', 'uses'=>'AppController@certificates']);
    Route::get('about/signup', ['as'=>'signup', 'uses'=>'AppController@signup']);
    Route::get('about/{slug?}', ['as'=>'about', 'uses'=>'AppController@about']);
    Route::get('contacts/contactinfo', ['as'=>'contactinfo', 'uses'=>'AppController@contactus']);
    Route::get('contacts/sitemap', ['as'=>'sitemap', 'uses'=>'AppController@sitemap']);
    Route::get('contacts/faq', ['as'=>'contacts', 'uses'=>'AppController@faq']);
    Route::get('contacts/{slug?}', ['as'=>'contacts', 'uses'=>'AppController@contacts']);
    Route::get('policies/{slug?}', ['as'=>'policies', 'uses'=>'AppController@policies']);
});
