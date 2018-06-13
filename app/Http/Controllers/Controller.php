<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App;
use Config;
use Session;
use DB;
use App\Api\Provider as Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\MailTemplates;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public $locale;
    public $api;
    public $db_prefix;
    public $la;
    public $user;
    public $settings;
    public $location;
    public $bodyclass = [];
    public $header = [];
    public $footer = [];
    public $page = [];

    public function __construct(Request $request, Api $api)
    {
      $this->api = new $api;

      // $this->api->syncGetUsers();
      // $this->api->syncSendOrders();
      // $this->api->syncGetOrders();
      // $this->api->syncGetProducts();
      // $this->api->syncGetProducers();
      // $this->api->syncGetDiscounts(['38', '40']);
      // $this->api->apiSearchGetList(['51470142615']);

      if(!Session::has('guest_id')):
        Session::put('guest_id', mt_rand(10000, 99999) + time());
      endif;

      $this->user = new \stdClass;
      $this->user->KundenId = 0;
      $this->user->country = 0;
      $this->locale = App::getLocale();
      $this->db_prefix = Config::get('app.locales.'.$this->locale.'.db_prefix');
      $this->months = Config::get('app.months');
      $urls = explode('/', rtrim($request->path(), '/'));
      $this->la = end($urls);
      $action = explode('@', \Route::currentRouteAction());
      $action = end($action);
      $locale = Session::has('locale') ? Session::get('locale') : '';

      User::establish();

      if(Session::get('user_id') && $this->user = User::entity()) {
        Session::put('user_id', $this->user->id);
        Session::put('kunden_id', $this->user->KundenId);
        $this->bodyclass[] = 'user-logged-in';
        define('SIGNEDIN', 1);
      } else {
        Session::put('user_id', 0);
        Session::put('kunden_id', 0);
        define('SIGNEDIN', 0);
      }

      $this->page = $this->setViewDescription($action);
      // $this->location = self::get_geo_location();
      $this->settings = $this->setGlobalSettings();
      $this->settings->order_vat = $this->user->country == 82 ? floatval($this->settings->order_vat) : 0;
      view()->share('_settings', $this->settings);
      view()->share('_scripts', $this->setGlobalSripts());
      view()->share('_cart', $this->getUserCart());
      view()->share('_countries', !SIGNEDIN ? DB::table('osc_countries')->select('id','name')->get() : []);
      view()->share('_headmenuall', $this->getHeaderMenuForAll());
      view()->share('_headmenusin', $this->getHeaderMenuForSignedIn());
      view()->share('_footmenu', $this->getFooterMenu());
      view()->share('_footsubmenu', $this->getFooterSubmenu());
      view()->share('_locale', $locale);
      view()->share('_action', $action);
      view()->share('_la', $this->la);
      view()->share('_segments', $request->segments());
      view()->share('_here', $request->url());
      view()->share('_route', \Route::currentRouteName());
      view()->share('_user', $this->user);
    }

    public function close() {
      /* fallbacks seo settings */
      $global_seo = $this->setGlobalSeo();
      $this->page->indexing = !intval($global_seo->indexing) ? 0 : $this->page->indexing;
      $this->page->meta_keys = !strlen(trim($this->page->meta_keys)) ? $global_seo->meta_keys : $this->page->meta_keys;
      $this->page->meta_title = !strlen(trim($this->page->meta_title)) ? $global_seo->meta_title : $this->page->meta_title;
      $this->page->meta_desc = !strlen(trim($this->page->meta_desc)) ? $global_seo->meta_desc : $this->page->meta_desc;
      /* fallbacks seo settings */

      view()->share('_page', $this->page);
      view()->share('_header', $this->setHeaderDescription());
      view()->share('_footer', $this->setFooterDescription());
      view()->share('_authmodals', $this->setAuthModalsDescription());
      view()->share('_contactmodals', $this->setContactModalsDescription());
      view()->share('_socials', $this->setSocials());
      view()->share('_bodyclass', implode(' ', $this->bodyclass));
    }

    public function setAuthModalsDescription() {
      $result = SIGNEDIN ? [] : collect(DB::select(
        "SELECT
        `".$this->db_prefix."text_1` as text_1,
        `".$this->db_prefix."text_2` as text_2,
        `".$this->db_prefix."text_3` as text_3,
        `".$this->db_prefix."text_4` as text_4,
        `".$this->db_prefix."text_5` as text_5,
        `".$this->db_prefix."text_6` as text_6,
        `".$this->db_prefix."text_7` as text_7,
        `".$this->db_prefix."text_8` as text_8,
        `".$this->db_prefix."text_9` as text_9,
        `".$this->db_prefix."text_10` as text_10,
        `".$this->db_prefix."text_11` as text_11,
        `".$this->db_prefix."text_12` as text_12,
        `".$this->db_prefix."text_13` as text_13,
        `".$this->db_prefix."text_14` as text_14,
        `".$this->db_prefix."text_15` as text_15,
        `".$this->db_prefix."text_16` as text_16,
        `".$this->db_prefix."text_17` as text_17,
        `".$this->db_prefix."text_18` as text_18,
        `".$this->db_prefix."text_19` as text_19,
        `".$this->db_prefix."text_20` as text_20,
        `".$this->db_prefix."text_21` as text_21,
        `".$this->db_prefix."text_22` as text_22,
        `".$this->db_prefix."text_23` as text_23,
        `".$this->db_prefix."text_24` as text_24,
        `".$this->db_prefix."text_25` as text_25,
        `".$this->db_prefix."text_26` as text_26,
        `".$this->db_prefix."text_27` as text_27,
        `".$this->db_prefix."text_28` as text_28,
        `".$this->db_prefix."text_29` as text_29,
        `".$this->db_prefix."text_30` as text_30,
        `".$this->db_prefix."text_31` as text_31,
        `".$this->db_prefix."text_32` as text_32,
        `".$this->db_prefix."text_33` as text_33,
        `".$this->db_prefix."text_34` as text_34,
        `".$this->db_prefix."text_35` as text_35,
        `".$this->db_prefix."text_36` as text_36,
        `".$this->db_prefix."text_37` as text_37,
        `".$this->db_prefix."text_38` as text_38,
        `".$this->db_prefix."text_39` as text_39,
        `".$this->db_prefix."text_40` as text_40,
        `".$this->db_prefix."text_41` as text_41,
        `".$this->db_prefix."text_42` as text_42,
        `".$this->db_prefix."text_43` as text_43,
        `".$this->db_prefix."text_44` as text_44,
        `".$this->db_prefix."text_45` as text_45,
        `".$this->db_prefix."text_46` as text_46,
        `".$this->db_prefix."text_47` as text_47,
        `".$this->db_prefix."text_48` as text_48,
        `".$this->db_prefix."text_49` as text_49
        FROM osc_page_elements LIMIT 1"
      ))->first();
      return $result;
    }

    public function setContactModalsDescription() {
      $result = collect(DB::select(
        "SELECT
        `".$this->db_prefix."text_50` as text_50,
        `".$this->db_prefix."text_51` as text_51,
        `".$this->db_prefix."text_52` as text_52,
        `".$this->db_prefix."text_53` as text_53,
        `".$this->db_prefix."text_54` as text_54
        FROM osc_page_elements LIMIT 1"
      ))->first();
      return $result;
    }

    public function setHeaderDescription() {
      $result = collect(DB::select(
        "SELECT
        `".$this->db_prefix."text_1` as text_1,
        `".$this->db_prefix."text_2` as text_2,
        `".$this->db_prefix."text_3` as text_3,
        `".$this->db_prefix."text_4` as text_4,
        `".$this->db_prefix."text_5` as text_5
        FROM osc_page_header LIMIT 1"
      ))->first();
      return $result;
    }

    public function setSocials() {
      $result = collect(DB::select("
        SELECT fb_link, gp_link, in_link, tw_link, yt_link, sk_link, ins_link, phone_number
        FROM osc_total_config LIMIT 1
      "))->first();
      return $result;
    }

    public function setGlobalSripts() {
      $result = collect(DB::select("
        SELECT afterHead, afterBody FROM osc_total_config LIMIT 1
      "))->first();
      return $result;
    }

    public function setGlobalSettings() {
      $result = collect(DB::select("
        SELECT order_vat FROM osc_total_config LIMIT 1
      "))->first();
      return $result;
    }

    public function setGlobalSeo() {
      $result = collect(DB::select(
        "SELECT `index` as indexing,
        `".$this->db_prefix."meta_title` as meta_title,
        `".$this->db_prefix."meta_keys` as meta_keys,
        `".$this->db_prefix."meta_desc` as meta_desc
         FROM osc_total_config LIMIT 1"))->first();
      return $result;
    }

    public function setFooterDescription() {
      $result = collect(DB::select(
        "SELECT
        `".$this->db_prefix."text_1` as text_1,
        `".$this->db_prefix."text_2` as text_2,
        `".$this->db_prefix."text_3` as text_3,
        `".$this->db_prefix."text_4` as text_4,
        `".$this->db_prefix."text_5` as text_5,
        `".$this->db_prefix."text_6` as text_6,
        `".$this->db_prefix."text_7` as text_7,
        `".$this->db_prefix."text_8` as text_8,
        `".$this->db_prefix."text_9` as text_9,
        `".$this->db_prefix."text_10` as text_10,
        `".$this->db_prefix."text_11` as text_11,
        `".$this->db_prefix."text_12` as text_12,
        `".$this->db_prefix."text_13` as text_13,
        `".$this->db_prefix."text_14` as text_14,
        `".$this->db_prefix."text_15` as text_15,
        `".$this->db_prefix."text_16` as text_16,
        `".$this->db_prefix."text_17` as text_17,
        `".$this->db_prefix."text_18` as text_18,
        `".$this->db_prefix."text_19` as text_19,
        `".$this->db_prefix."text_20` as text_20
        FROM osc_page_footer LIMIT 1"
      ))->first();
      return $result;
    }

    public function setViewDescription($action) {
      $result = new \stdClass();
      if($action=='home'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31
          FROM osc_page_home LIMIT 1"
        ))->first();
        $result->whyus = DB::select(
          "SELECT cover,
          `".$this->db_prefix."name` as name
          FROM osc_page_home_whyus
          WHERE block = 0"
        );
      elseif($action=='whyus'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_about_whyus LIMIT 1"
        ))->first();
      elseif($action=='signup'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3
          FROM osc_page_about_signup LIMIT 1"
        ))->first();
      elseif($action=='certificates'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3
          FROM osc_page_about_certificates LIMIT 1"
        ))->first();
      elseif($action=='benefits'):
        $result = collect(DB::select(
          "SELECT `indexing`,`file`,`alt`,`title`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_about_benefits LIMIT 1"
        ))->first();
      elseif($action=='team'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5
          FROM osc_page_about_team LIMIT 1"
        ))->first();
      elseif($action=='gallery'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5
          FROM osc_page_about_gallery LIMIT 1"
        ))->first();
      elseif($action=='sitemap'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3
          FROM osc_page_contacts_sitemap LIMIT 1"
        ))->first();
      elseif($action=='joinus'):
        $result = collect(DB::select(
          "SELECT `indexing`,`file`,`alt`,`title`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10
          FROM osc_page_about_joinus LIMIT 1"
        ))->first();
      elseif($action=='companyprofile'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15
          FROM osc_page_about_profile LIMIT 1"
        ))->first();
        $result->list = DB::select(
          "SELECT cover,
          `".$this->db_prefix."name` as name
          FROM osc_page_about_profile_list
          WHERE block = 0"
        );
      elseif($action=='contactus'):
        $result = collect(DB::select(
          "SELECT `indexing`, `lat`, `lng`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20
          FROM osc_page_contacts_contactus LIMIT 1"
        ))->first();
        $result->list = DB::select(
          "SELECT cover,
          `".$this->db_prefix."name` as name
          FROM osc_page_about_team_list
          WHERE block = 0"
        );
      elseif($action=='products'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23
          FROM osc_page_search LIMIT 1"
        ))->first();
      elseif($action=='product'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13
          FROM osc_page_search_product LIMIT 1"
        ))->first();
      elseif($action=='parts'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4
          FROM osc_page_parts LIMIT 1"
        ))->first();
      elseif($action=='brand'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4
          FROM osc_page_parts_brand LIMIT 1"
        ))->first();
      elseif($action=='posts'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3
          FROM osc_page_posts LIMIT 1"
        ))->first();
      elseif($action=='post'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4
          FROM osc_page_post LIMIT 1"
        ))->first();
      elseif($action=='prices'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11
          FROM osc_page_pricelists LIMIT 1"
        ))->first();
      elseif($action=='pricelists'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11
          FROM osc_page_pricelists LIMIT 1"
        ))->first();
      elseif($action=='import_modal'):
        $result->import_modal = collect(DB::select(
          "SELECT
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31,
          `".$this->db_prefix."text_32` as text_32
          FROM osc_page_profile_import LIMIT 1"
        ))->first();
      elseif($action=='cart'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31
          FROM osc_page_profile_cart LIMIT 1"
        ))->first();
        $result->import_modal = collect(DB::select(
          "SELECT
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31,
          `".$this->db_prefix."text_32` as text_32
          FROM osc_page_profile_import LIMIT 1"
        ))->first();
        $result->substitution_modal = collect(DB::select(
          "SELECT
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10
          FROM osc_page_profile_substitution LIMIT 1"
        ))->first();
      elseif($action=='discounts'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10
          FROM osc_page_profile_discounts LIMIT 1"
        ))->first();
      elseif($action=='myorders'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18
          FROM osc_page_profile_orders LIMIT 1"
        ))->first();
      elseif($action=='myorder'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31,
          `".$this->db_prefix."text_32` as text_32,
          `".$this->db_prefix."text_33` as text_33,
          `".$this->db_prefix."text_34` as text_34,
          `".$this->db_prefix."text_35` as text_35,
          `".$this->db_prefix."text_36` as text_36,
          `".$this->db_prefix."text_37` as text_37,
          `".$this->db_prefix."text_38` as text_38,
          `".$this->db_prefix."text_39` as text_39,
          `".$this->db_prefix."text_40` as text_40,
          `".$this->db_prefix."text_41` as text_41,
          `".$this->db_prefix."text_42` as text_42,
          `".$this->db_prefix."text_43` as text_43,
          `".$this->db_prefix."text_44` as text_44,
          `".$this->db_prefix."text_45` as text_45,
          `".$this->db_prefix."text_46` as text_46,
          `".$this->db_prefix."text_47` as text_47,
          `".$this->db_prefix."text_48` as text_48,
          `".$this->db_prefix."text_49` as text_49,
          `".$this->db_prefix."text_50` as text_50,
          `".$this->db_prefix."text_51` as text_51,
          `".$this->db_prefix."text_52` as text_52,
          `".$this->db_prefix."text_53` as text_53,
          `".$this->db_prefix."text_54` as text_54,
          `".$this->db_prefix."text_55` as text_55,
          `".$this->db_prefix."text_56` as text_56,
          `".$this->db_prefix."text_57` as text_57,
          `".$this->db_prefix."text_58` as text_58,
          `".$this->db_prefix."text_59` as text_59,
          `".$this->db_prefix."text_60` as text_60,
          `".$this->db_prefix."text_61` as text_61,
          `".$this->db_prefix."text_62` as text_62
          FROM osc_page_profile_order LIMIT 1"
        ))->first();
      elseif($action=='security'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13
          FROM osc_page_profile_secure LIMIT 1"
        ))->first();
      elseif($action=='settings'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21,
          `".$this->db_prefix."text_22` as text_22,
          `".$this->db_prefix."text_23` as text_23,
          `".$this->db_prefix."text_24` as text_24,
          `".$this->db_prefix."text_25` as text_25,
          `".$this->db_prefix."text_26` as text_26,
          `".$this->db_prefix."text_27` as text_27,
          `".$this->db_prefix."text_28` as text_28,
          `".$this->db_prefix."text_29` as text_29,
          `".$this->db_prefix."text_30` as text_30,
          `".$this->db_prefix."text_31` as text_31,
          `".$this->db_prefix."text_32` as text_32,
          `".$this->db_prefix."text_33` as text_33,
          `".$this->db_prefix."text_34` as text_34,
          `".$this->db_prefix."text_35` as text_35,
          `".$this->db_prefix."text_36` as text_36,
          `".$this->db_prefix."text_37` as text_37
          FROM osc_page_profile_settings LIMIT 1"
        ))->first();
      elseif($action=='balance'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2,
          `".$this->db_prefix."text_3` as text_3,
          `".$this->db_prefix."text_4` as text_4,
          `".$this->db_prefix."text_5` as text_5,
          `".$this->db_prefix."text_6` as text_6,
          `".$this->db_prefix."text_7` as text_7,
          `".$this->db_prefix."text_8` as text_8,
          `".$this->db_prefix."text_9` as text_9,
          `".$this->db_prefix."text_10` as text_10,
          `".$this->db_prefix."text_11` as text_11,
          `".$this->db_prefix."text_12` as text_12,
          `".$this->db_prefix."text_13` as text_13,
          `".$this->db_prefix."text_14` as text_14,
          `".$this->db_prefix."text_15` as text_15,
          `".$this->db_prefix."text_16` as text_16,
          `".$this->db_prefix."text_17` as text_17,
          `".$this->db_prefix."text_18` as text_18,
          `".$this->db_prefix."text_19` as text_19,
          `".$this->db_prefix."text_20` as text_20,
          `".$this->db_prefix."text_21` as text_21
          FROM osc_page_profile_balance LIMIT 1"
        ))->first();
      elseif($action=='terms'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_terms LIMIT 1"
        ))->first();
      elseif($action=='legal'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_legal LIMIT 1"
        ))->first();
      elseif($action=='privacy'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_privacy LIMIT 1"
        ))->first();
      elseif($action=='returns'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_returns LIMIT 1"
        ))->first();
      elseif($action=='shipping'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_shipping LIMIT 1"
        ))->first();
      elseif($action=='secure'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_secure LIMIT 1"
        ))->first();
      elseif($action=='guarantee'):
        $result = collect(DB::select(
          "SELECT `indexing`,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc,
          `".$this->db_prefix."text_1` as text_1,
          `".$this->db_prefix."text_2` as text_2
          FROM osc_page_conventions_guarantee LIMIT 1"
        ))->first();
      else:
        $result = collect(DB::select(
          "SELECT `index` as indexing,
          `".$this->db_prefix."meta_title` as meta_title,
          `".$this->db_prefix."meta_keys` as meta_keys,
          `".$this->db_prefix."meta_desc` as meta_desc
          FROM osc_total_config LIMIT 1"
        ))->first();
      endif;
      return $result;

    }

    public function getHeaderMenuForAll() {
      $res = DB::table('osc_menu')
        ->select('id', $this->db_prefix.'name as name', 'alias', 'classes', 'signedin_only')
        ->where(['block' => 0, 'parent_id' => 0, 'show_header' => 1, 'signedin_section' => 0])
        ->orderBy('order_id', 'asc')
        ->get();
      if($res):
        foreach($res as &$parent):
          $parent->submenu = DB::table('osc_menu')
            ->select('id', $this->db_prefix.'name as name', 'alias', 'classes', 'signedin_only')
            ->where(['block' => 0, 'parent_id' => $parent->id, 'show_header' => 1, 'signedin_section' => 0])
            ->orderBy('order_id', 'asc')
            ->get();
        endforeach;
      endif;
      return $res;
    }

    public function getHeaderMenuForSignedIn() {
      $res = DB::table('osc_menu')
        ->select('id', $this->db_prefix.'name as name', 'alias', 'classes')
        ->where(['block' => 0, 'parent_id' => 0, 'show_header' => 1, 'signedin_section' => 1])
        ->orderBy('order_id', 'asc')
        ->get();
      return $res;
    }

    public function getProfileMenu() {
      $res = DB::table('osc_menu')
        ->select('id', $this->db_prefix.'name as name', 'alias', 'classes', 'icon')
        ->where(['block' => 0, 'show_profile' => 1])
        ->orderBy('order_id', 'asc')
        ->get();
      return $res;
    }

    public function getFooterMenu() {
      $res = DB::table('osc_menu')
        ->select('id', $this->db_prefix.'name as name', 'alias', 'classes', 'signedin_only')
        ->where(['block' => 0, 'parent_id' => 0, 'show_footer' => 1])
        ->orderBy('order_id', 'asc')
        ->get();
      return $res;
    }

    public function getFooterSubmenu() {
      $res = DB::table('osc_menu')
        ->select('id', $this->db_prefix.'name as name', 'alias', 'classes', 'signedin_only')
        ->where(['block' => 0, 'parent_id' => 0, 'show_footer_2' => 1])
        ->orderBy('order_id', 'asc')
        ->get();
      return $res;
    }

    public function getHomeBanners() {
      $res = DB::table('osc_banners')
        ->select('id', $this->db_prefix.'name as name', $this->db_prefix.'data as data', $this->db_prefix.'alt as alt', $this->db_prefix.'title as title', 'file')
        ->where('block', 0)
        ->orderBy('order_id', 'asc')
        ->get();
      return $res;
    }

    public function getHomeProducers() {
      $res = DB::table('osc_producers')
        ->select('Name', 'Logo', 'Id')
        ->where(['show_home' => 1, 'Block' => 0])
        ->whereRaw('CHAR_LENGTH(Logo) > 5')
        ->get();
      return array_chunk($res, 2);
    }

    public function getFaqs() {
      $res = DB::select(
        "SELECT
        A.id,
        A.".$this->db_prefix."question as question,
        A.".$this->db_prefix."answer as answer
        FROM osc_faq AS A
        WHERE A.block=0
        ORDER BY A.order_id"
      );
      foreach($res as &$faq):
        $tags = collect(
          DB::select(
            "SELECT
            FT.alias,
            FT.".$this->db_prefix."name as name
            FROM osc_faq_tags AS FT
            WHERE FT.block = 0
            AND FT.id IN (SELECT tag_id FROM osc_faq_tags_ref WHERE faq_id = $faq->id)
            "
          )
        );
        $faq->tagaliases = $tags->pluck('alias')->toArray();
        $faq->tagnames = $tags->pluck('name')->toArray();
      endforeach;
      return $res;
    }

    public function getFaqsHashtages() {
      $res = DB::table('osc_faq_tags')
        ->select('id', $this->db_prefix.'name as name', 'alias')
        ->where(['block' => 0])
        ->get();
      return $res;
    }

    public function getArticlesHashtages() {
      $res = DB::table('osc_article_tags')
        ->select('id', $this->db_prefix.'name as name', 'alias')
        ->where(['block' => 0])
        ->get();
      return $res;
    }

    public function getHomeArticles() {
      $res = DB::select(
        "SELECT A.id, A.img_alt, A.img_title, A.alias, A.dateCreate as created,
        A.".$this->db_prefix."name as name,
        A.".$this->db_prefix."content as content,
        (SELECT file FROM osc_files_ref WHERE `ref_table`='articles' AND `ref_id`=A.id ORDER BY id DESC LIMIT 1) as filename,
        (SELECT ".$this->db_prefix."name as name FROM osc_categories WHERE `id`=A.cat_id LIMIT 1) as category
        FROM osc_articles AS A
        WHERE A.block=0
        ORDER BY A.order_id"
      );
      foreach($res as &$post):
        $tags = collect(
          DB::select(
            "SELECT
            AT.".$this->db_prefix."name as name
            FROM osc_article_tags AS AT
            WHERE AT.block = 0
            AND AT.id IN (SELECT tag_id FROM osc_article_tags_ref WHERE art_id = $post->id)
            "
          )
        );
        $post->tagnames = $tags->pluck('name')->toArray();
      endforeach;
      return $res;
    }

    public function getCertificates() {
      $res = DB::select(
        "SELECT A.id, A.filename, A.img_alt, A.img_title,
        A.".$this->db_prefix."name as name,
        A.".$this->db_prefix."content as content
        FROM osc_certificates AS A
        WHERE A.block=0
        ORDER BY A.order_id"
      );
      foreach($res as $certificate):
        $certificate->images = DB::table('osc_files_ref')
          ->select('file','alt','title')
          ->where(['ref_id'=>$certificate->id, 'ref_table'=>'certificates'])
          ->get();
        foreach($certificate->images as &$image) {
            $image->file = url('/public/img/gallery/'.$image->file);
        };
        $certificate->images = $this->cast_to_array($certificate->images);
      endforeach;
      return $res;
    }

    public function getArticles() {
      $res = DB::select(
        "SELECT A.id, A.img_alt, A.img_title, A.alias, A.dateCreate as created,
        (SELECT file FROM osc_files_ref WHERE `ref_table`='articles' AND `ref_id`=A.id ORDER BY id DESC LIMIT 1) as filename,
        A.".$this->db_prefix."name as name,
        A.".$this->db_prefix."content as content,
        (SELECT ".$this->db_prefix."name as name FROM osc_categories WHERE `id`=A.cat_id LIMIT 1) as category
        FROM osc_articles AS A
        WHERE A.block=0
        ORDER BY A.order_id"
      );
      foreach($res as &$post):
        $tags = collect(
          DB::select(
            "SELECT
            AT.".$this->db_prefix."name as name, AT.alias
            FROM osc_article_tags AS AT
            WHERE AT.block = 0
            AND AT.id IN (SELECT tag_id FROM osc_article_tags_ref WHERE art_id = $post->id)
            "
          )
        );
        $post->tagaliases = $tags->pluck('alias')->toArray();
        $post->tagnames = $tags->pluck('name')->toArray();
      endforeach;
      return $res;
    }

    public function getArticle($alias) {
      $res = collect(DB::select(
        "SELECT A.id, A.img_alt, A.img_title, A.alias, A.dateCreate as created,
        A.".$this->db_prefix."name as name,
        A.".$this->db_prefix."content as content,
        (SELECT ".$this->db_prefix."name as name FROM osc_categories WHERE `id`=A.cat_id LIMIT 1) as category
        FROM osc_articles AS A
        WHERE A.block=0
        AND A.alias = '$alias'
        LIMIT 1"
      ))->first();
      if($res):
        $tags = collect(
          DB::select(
            "SELECT
            AT.".$this->db_prefix."name as name, alias
            FROM osc_article_tags AS AT
            WHERE AT.block = 0
            AND AT.id IN (SELECT tag_id FROM osc_article_tags_ref WHERE art_id = $res->id)
            "
          )
        );
        $res->tagaliases = $tags->pluck('alias')->toArray();
        $res->tagnames = $tags->pluck('name')->toArray();
        $res->gallery = DB::table('osc_files_ref')
          ->select('file','alt','title')
          ->where(['ref_id'=>$res->id,'ref_table'=>'articles'])
          ->get();
        foreach($res->gallery as &$image) {
            $image->file = url('/public/img/content/'.$image->file);
        };
        $res->gallery = $this->cast_to_array($res->gallery);
        $res->cover = !empty($res->gallery) ? end($res->gallery)['file'] : false;
      endif;
      return $res;
    }

    public function getPricelists() {
      $kunden_id = Session::get('kunden_id');
      $res = DB::select(
        "SELECT DG.OwnerSupplierId, DG.Comment, M.Id, M.Name, M.cover, M.Logo, M.Modified, M.New, CDG.ClientId
        FROM crm_discountgroups DG
        LEFT JOIN crm_producers AS M ON DG.ProducerId = M.Id
        LEFT JOIN crm_clientdiscountgroups CDG ON CDG.DiscountGroupId = DG.Id
        WHERE CDG.ClientId = $kunden_id
        GROUP BY M.id, DG.OwnerSupplierId
        ORDER BY M.Name, DG.OwnerSupplierId
        LIMIT 1000"
      );
      return $res;
    }

    public function getClientPricelist($producer) {
      $kunden_id = Session::get('kunden_id');
      $res = DB::select(
        "SELECT P.*, PR.Name as producer_name, PR.Logo producer_logo,
        IF(CDG.Factor, P.Price * CDG.Factor, 0) as user_price,
        IF(CDG.Factor, CDG.Factor, 0) as factor,
        IF(CDG.Factor, CDG.Visibility, 0) as factor_visibility,
        CONCAT(PR.Name, ' ', IF(CHAR_LENGTH(DG.Comment), CONCAT(DG.Name, ' / ', DG.Comment), DG.Name)) as factor_group
        FROM crm_products P
        LEFT JOIN crm_producers PR ON PR.Id = P.ProducerId
        LEFT JOIN crm_discountgroups AS DG ON DG.ProducerId = P.ProducerId
        LEFT JOIN crm_clientdiscountgroups CDG ON CDG.DiscountGroupId = DG.id
        WHERE PR.Name = '$producer' 
        AND CDG.ClientId = $kunden_id
        GROUP BY P.Code
        ORDER BY P.Code, P.Price
        LIMIT 100000"
      );
      return $res;
    }

    public function checkUser($login, $pass = false) {
      if($pass):
        $user = collect(
          DB::select("SELECT * FROM osc_users WHERE login='$login' AND pass='".strtoupper(md5($pass))."' AND block=0 LIMIT 1")
        )->first();
      else:
        $user = collect(
          DB::select("SELECT * FROM osc_users WHERE login='$login' LIMIT 1")
        )->first();
      endif;
      return !empty($user) ? $user->id : false;
    }

    public function checkUserCredentials($id) {
      $user = DB::table('osc_users')->where(['id'=>$id])->first();
      return $user ? true : false;
    }

    public function checkUserEmail($email) {
      $user = DB::table('osc_users')->where(['email'=>$email])->first();
      return !empty($user) ? $user : false;
    }

    public function checkUserPassword($pass) {
      $uid = Session::get('user_id');
      $user = DB::table('osc_users')->where(['id'=>$uid, 'pass'=>md5($pass)])->first();
      return !empty($user) ? $user : false;
    }

    public function getUserData(array $fields = []) {
      $uid = Session::get('user_id');
      $user = collect(
        DB::select(
          "SELECT U.*,
          (SELECT name FROM osc_countries WHERE id = U.country) as country_name
          FROM osc_users as U
          WHERE U.id='$uid'
          LIMIT 1"
          )
      )->first();
      return !empty($user) ? $user : null;
    }

    public function getUserCart($products = false) {
      $user_id = Session::get('user_id');
      $kunden_id = isset($this->user->KundenId) ? $this->user->KundenId : 0;
      $cart = new \stdClass;
      $cart->total = 0;
      $cart->qty = 0;
      $cart->products = DB::table('crm_cart')
        ->select('id','product_id','qty','comment','vin','price as Price', 'code as Code')
        ->where(['user_id'=>$user_id])
        ->get();

      foreach($cart->products as &$cart_item):
        $item = $cart_item;
        if($products):
          $product = collect(DB::select(
            "SELECT P.Note, P.AltCode, P.Details, P.Code, P.Weight, P.Price as OriginPrice,
            MF.Name as producer_name,
            MF.Logo as producer_logo,
            IF(CDG.Factor, CDG.Visibility, 0) as FactorVisibility,
            IF(CDG.Factor, CDG.Factor, U.Factor) as Factor,
            IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as FactorGroup,
            IF(CDG.Factor, CDG.DiscountGroupId, 0) as cdg,
            IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= $item->qty, P.WsPrice * CDG.Factor, P.Price * CDG.Factor), 0) as Price
            FROM crm_products AS P
            LEFT JOIN osc_users AS U ON U.id = $user_id
            LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
            LEFT JOIN crm_discountgroups AS DG ON (DG.Id = P.DiscountGroupId AND DG.ProducerId = P.ProducerId)
            LEFT JOIN crm_producers AS MF ON MF.Id = P.ProducerId
            WHERE P.id = $cart_item->product_id
            LIMIT 1"
          ))->first();
          $cart_item->not_found      = $product ? 0 : 1;
          $cart_item->producer_name  = $product ? $product->producer_name : '-';
          $cart_item->producer_logo  = $product ? $product->producer_logo : '-';
          $cart_item->Details        = $product ? $product->Details : '-';
          $cart_item->AltCode        = $product ? $product->AltCode : '-';
          $cart_item->qty            = $product ? $cart_item->qty : 0;
          $cart_item->Price          = $product ? $product->Price : 0;
          $cart_item->discount       = $product && $product->Factor < 1 && $product->FactorVisibility ? ( 100 - ( 100 * $product->Factor ) ).'%' : '-';
          $cart_item->FactorGroup    = $product ? $product->FactorGroup : '-';
        endif;
        $cart->total += round(($cart_item->Price * $cart_item->qty), 2);
        $cart->qty += $cart_item->qty;
      endforeach;
      $cart->ftotal = (float)$cart->total;
      $cart->total = number_format($cart->total, 2, ',', ' ');
      $cart->vftotal = round($this->settings->order_vat * $cart->ftotal + $cart->ftotal, 2);
      $cart->vtotal = number_format($cart->vftotal, 2, ',', ' ');
      if(!$products) unset($cart->products);
      return $cart;
    }

    public function insertProducts() {
      ini_set('max_execution_time', 6000);
      ini_set('memory_limit', '2G');
      function frand($min, $max, $decimals = 0) {
          $scale = pow(10, $decimals);
          return mt_rand($min * $scale, $max * $scale) / $scale;
      }
      $mfs = DB::select("select * from producers");
      $now = date('Y-m-d H:i:s');
      foreach($mfs as $m) {
        for($x=1000000; $x>0; $x--) {
          $code = mt_rand(100000000, 999999999);
          $price = frand(1, 10000, 2);
          DB::insert("INSERT INTO products (ProducerId,DiscountGroupId,Code,Price,Details,Weight,Note,AltCode,Deleted,Block,Created,Modified,CreatedUserId,ModifiedUserId)
            VALUES ('".$m->Id."','1','".$code."','".$price."','Product Artikel #".$code."','0.00','Product Note #".$code."','".$code."','0','0','".$now."','".$now."','1','1')");
        }
      }
      exit();
    }

    public function getUserOrders($from, $to, $sku = false, $keyword = false) {
      $uid = Session::get('user_id');
      $kid = Session::get('kunden_id');
      $from = date('Y-m-d', strtotime($from)).' 23:59:59';
      $to = date('Y-m-d', strtotime($to)).' 23:59:59';
      $condition = "";
      if($sku && strlen($sku)) $condition .= " AND P.code LIKE '$sku%'";
      if($keyword && strlen($keyword)) $condition .= " AND (O.comment LIKE '%$keyword%' OR OP.comment LIKE '%$keyword%' OR OP.vin LIKE '%$keyword%' OR P.Details LIKE '%$keyword%' OR P.Note LIKE '%$keyword%')";
      $query = "SELECT O.*, U.KundenCode as KundenCode, CONCAT(U.fname,' ',U.lname) as customer,
        SUM(P.Price * OP.qty) as netto,
        SUM(
          IF(CDG.Factor,
            IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor * OP.qty, P.Price * CDG.Factor * OP.qty),
          0)
        ) as brutto,
        (SELECT name FROM crm_orders_statuses WHERE id=O.status) as status_name,
        (SELECT SUM(qty) FROM crm_orders_products WHERE order_id=O.id) as products,
        (SELECT SUM(in_stock) FROM crm_orders_products WHERE order_id=O.id) as instock,
        (SELECT SUM(sent) FROM crm_orders_products WHERE order_id=O.id) as sent
        FROM crm_orders AS O
        LEFT JOIN crm_orders_products AS OP ON ( OP.order_id = O.id AND OP.removed = 0 )
        LEFT JOIN crm_products as P on P.id = OP.product_id
        LEFT JOIN osc_users AS U ON ( U.id = O.user_id OR U.KundenId = O.kunden_id )
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
        WHERE ( O.user_id = $uid OR O.kunden_id = $kid )
        AND O.created BETWEEN '$from' AND '$to'
        AND O.removed = 0
        $condition
        GROUP BY O.id
        ORDER BY O.id DESC";
      $orders = DB::select($query);
      return $orders;
    }

    public function getUserDiscounts() {
      $uid = Session::get('user_id');
      $discounts = DB::select(
        "SELECT CDG.Factor, CDG.Discount, CDG.DiscountGroupId,
        IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as Name,
        MF.Name as producer_name,
        MF.Logo as producer_logo,
        (SELECT COUNT(id) FROM crm_products WHERE DiscountGroupId = CDG.DiscountGroupId) as products_amount
        FROM crm_clientdiscountgroups as CDG
        LEFT JOIN crm_discountgroups AS DG ON DG.Id = CDG.DiscountGroupId
        LEFT JOIN crm_producers AS MF ON MF.Id = DG.ProducerId
        LEFT JOIN osc_users AS U ON U.KundenId = CDG.ClientId
        WHERE U.id = $uid
        AND CDG.Factor BETWEEN 0 AND 1
        ORDER BY CAST(DG.Name AS UNSIGNED), MF.Name"
      );

      return $discounts;
    }

    public function sendOrderEmail($id) {
      $order = $this->getOrderDetails($id);
      if($order && !$order->mail_sent):
        $html = '';
        $vars = [
          'order_id' => $order->wb_id,
          'created_at' => date('d.m.Y H:i', strtotime($order->created)),
          'vat' => number_format($order->vat, 2, '.', '').'%',
          'status' => $order->status_name,
          'brutto' => number_format($order->brutto, 2, ',', ' '),
          'netto' => number_format($order->netto, 2, ',', ' '),
          'products' => '',
        ];
        foreach($order->products as $i => $product):
          $vars['products'] .= '<tr>
            <td>'. ( $i + 1 ) .'</td>
            <td>'. $product->Code .'</td>
            <td>'. $product->Details .'</td>
            <td>'. number_format($product->brutto, 2, ',', ' ') .'</td>
            <td>'. $product->qty .'</td>
            <td>'. number_format($product->brutto_sum, 2, ',', ' ') .'</td>
         </tr>
         ';
        endforeach;
        $vars['products'] .= '<tr><td colspan="5"></td><td>'. number_format($order->brutto, 2, ',', ' ') .'</td></tr>';
        MailTemplates::build('new_order',$order->email, $vars, $this->db_prefix);
        Order::where(['id'=>$order->id])->update(['mail_sent'=>1]);
      endif;
    }

    public function getOrderDetails($id) {
      $uid = Session::get('user_id');
      $kid = Session::get('kunden_id');
      $query = "SELECT O.*,
        (SELECT name FROM crm_orders_statuses WHERE id=O.status) as status_name,
        (SELECT CONCAT(fname,' ',lname) FROM osc_users WHERE id=O.user_id LIMIT 1) as customer,
        (SELECT email FROM osc_users WHERE id=O.user_id LIMIT 1) as email
        FROM crm_orders AS O
        WHERE (O.user_id = $uid OR O.kunden_id = $kid)
        AND O.id = '$id'
        AND O.removed = 0
        LIMIT 1";
      $order = collect(DB::select($query))->first();
      if($order):
        $order->netto = 0;
        $order->brutto = 0;
        $order->instock = 0;
        $order->sent = 0;
        $order->all = 0;
        $order->sum = 0;
        $order->products =  DB::select(
          "SELECT OP.id, OP.qty, OP.qty_ab, OP.status, OP.comment, OP.in_stock, OP.sent, OP.modified, OP.history, OP.code as Code, OP.changed_code, OP.stop, P.Details,
          P.Price as netto, (P.Price * OP.qty) as netto_sum,
          IF(CDG.Factor, CDG.DiscountGroupId, 0) as cdg,
          IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as cdgn,
          IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor, P.Price * CDG.Factor),0) as brutto,
          IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor * OP.qty, P.Price * CDG.Factor * OP.qty),0) as brutto_sum,
          IF(CDG.Factor, CDG.Factor, U.Factor) as factor,
          IF(CDG.Factor, CDG.Visibility, 0) as factor_visibility,
          MF.Id as producer_id,
          MF.Name as producer_name,
          MF.Logo as producer_logo
          FROM crm_orders_products as OP
          LEFT JOIN crm_products AS P ON P.id = OP.product_id
          LEFT JOIN osc_users AS U ON (U.id = $order->user_id OR U.KundenId = $order->kunden_id)
          LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
          LEFT JOIN crm_discountgroups AS DG ON (DG.Id = P.DiscountGroupId AND DG.ProducerId = P.ProducerId)
          LEFT JOIN crm_producers AS MF ON MF.Id = P.ProducerId
          WHERE OP.order_id = $order->id
          AND OP.removed=0"
        );
        foreach($order->products as &$product):
            $order->netto += $product->netto;
            $order->brutto += $product->brutto_sum;
            $order->instock += $product->in_stock;
            $order->sent += $product->sent;
            $order->all += $product->qty;
            $product->history = json_decode($product->history);
            // dd($product->history);
            $product->discount = $product->factor < 1 && $product->factor_visibility ? ( 100 - ( 100 * $product->factor ) ).'%' : '-';
            $product->ClientDiscountGroupId = $product->cdg ? $product->cdgn : '-';
        endforeach;
        $order->netto = round($order->brutto, 2);
        $order->brutto = round($order->brutto + ( $order->brutto / 100 * $order->vat ), 2);
      endif;
      return $order;
    }

    public function getOrderTotals($id) {
      $query = "SELECT
        O.vat,
        SUM(P.Price * OP.qty) as netto,
        SUM(
          IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor * OP.qty, P.Price * CDG.Factor * OP.qty), 0)
        ) as brutto,
        (SELECT SUM(qty) FROM crm_orders_products WHERE order_id=O.id) as products,
        (SELECT SUM(in_stock) FROM crm_orders_products WHERE order_id=O.id) as instock,
        (SELECT SUM(sent) FROM crm_orders_products WHERE order_id=O.id) as sent
        FROM crm_orders AS O
        LEFT JOIN crm_orders_products AS OP ON OP.order_id = O.id
        LEFT JOIN crm_products as P on P.id = OP.product_id
        LEFT JOIN osc_users AS U ON U.id = O.user_id
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
        WHERE O.id=$id
        AND OP.removed=0
        LIMIT 1";
      $order = collect(DB::select($query))->first();
      if($order):
        $order->netto = round($order->brutto, 2);
        $order->brutto = round($order->brutto + ( $order->brutto / 100 * $order->vat ), 2);
      endif;
      return $order;
    }

    public function getProduct($id, $kunden_id) {
      $product = collect(DB::select(
        "SELECT P.Id, P.DiscountGroupId, P.Details, P.Code, P.Weight, P.WsPrice, P.WsQty, P.Price as OriginPrice,
        IF(CDG.Factor, CDG.id, 0) as cdg,
        IF(CDG.Factor, CDG.Name, 0) as cdgn,
        IF(CDG.Factor, CDG.Factor, 0) as Factor,
        IF(CDG.Factor, CDG.Visibility, 0) as FactorVisibility,
        IF(CDG.Factor, P.Price * CDG.Factor, 0) as Price
        FROM crm_products AS P
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = $kunden_id)
        LEFT JOIN osc_users AS U ON U.KundenId = $kunden_id
        WHERE P.id=$id
        LIMIT 1"
      ))->first();
      if($product):
        $product->discount = $product->cdg && $product->Factor < 1 && $product->FactorVisibility ? ( 100 - ( 100 * $product->Factor ) ).'%' : '-';
        $product->ClientDiscountGroupId = $product->cdgn ? $product->cdgn : '-';
      endif;
      return $product;
    }

    public function getProductByQuery($query='', $field='') {
      $kunden_id = Session::get('kunden_id');
      $product = collect(DB::select(
        "SELECT P.*,
        P.Price as netto,
        IF(CDG.Factor, CDG.Factor, 0) as factor,
        IF(CDG.Factor, CDG.Visibility, 0) as factor_visibility,
        IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as factor_group,
        IF(DG.Comment, DG.Comment, null) as factor_comment,
        IF(CDG.Factor, P.Price * CDG.Factor, 0) as user_price,
        MF.Name as producer_name,
        MF.Logo as producer_logo
        FROM crm_products AS P
        LEFT JOIN osc_users AS U ON U.KundenId = $kunden_id
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
        LEFT JOIN crm_discountgroups AS DG ON (DG.Id = P.DiscountGroupId AND DG.ProducerId = P.ProducerId)
        LEFT JOIN crm_producers AS MF ON MF.Id = P.ProducerId
        WHERE P.$field = '$query'
        LIMIT 1"
      ))->first();
      if($product):
        $product->substitutes = $this->getSubstitution($product->Id, $kunden_id);
      endif;
      return $product;
    }

    public function getSubstitution($id, $kunden_id) {
      $altcodes = [];
      $products = [];
      $product = Product::select(['AltCode', 'AltCode2'])->where(['Id'=>$id])->first();
      if($product):
        $product = $product->toArray();
        $altcodes = array_filter(array_values($product));
        if($altcodes):
          $products = $this->getSubstitutionProducts($altcodes, $kunden_id);
          if(empty($products)):
            $sync = $this->api->apiSearchGetList($altcodes, $kunden_id);
            $products = $this->getSubstitutionProducts($altcodes, $kunden_id);
          endif;
          if($products):
            foreach($products as &$product):
              $product->discount = $product->cdg && $product->factor < 1 && $product->factor_visibility ? ( 100 - ( 100 * $product->factor ) ).'%' : '-';
              $product->factor_group = $product->cdg ? $product->factor_group : '-';
              $product->origin = $id;
            endforeach;
          endif;
        endif;
      endif;
      return $products;
    }

    public function getSubstitutionProducts($codes, $kunden_id) {
      $products = DB::select(
        "SELECT P.*,
        P.Price as netto,
        IF(CDG.Factor, P.Price * CDG.Factor, 0) as brutto,
        IF(CDG.Factor, CDG.id, 0) as cdg,
        IF(CDG.Factor, CDG.Factor, 0) as factor,
        IF(CDG.Factor, CDG.Visibility, 0) as factor_visibility,
        IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as factor_group,
        MF.Name as producer_name,
        MF.Logo as producer_logo
        FROM crm_products AS P
        LEFT JOIN osc_users AS U ON U.KundenId = $kunden_id
        LEFT JOIN crm_producers AS MF ON MF.Id = P.ProducerId
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
        LEFT JOIN crm_discountgroups AS DG ON (DG.Id = P.DiscountGroupId AND DG.ProducerId = P.ProducerId)
        WHERE P.Code IN ('".implode("','", $codes)."')
        LIMIT 10"
      );
      return $products;
    }

    public function getProducersCategories() {
      $res = DB::select(
        "SELECT C.id, C.logo,
        C.".$this->db_prefix."name as name
        FROM osc_pcatecories AS C
        WHERE C.block=0"
      );
      foreach($res as &$category):
        $category->producers = DB::select(
          "SELECT P.name, P.id FROM osc_producers as P
          WHERE P.Block = 0 AND P.id IN (SELECT producer_id FROM osc_producers_categories WHERE `category_id`=$category->id)"
        );
      endforeach;
      return $res;
    }

    public function getProducerByAlias($alias) {
      $res = collect(
        DB::table('osc_producers')
        ->select('Id','Name','Logo','cover','products_amount',
          $this->db_prefix.'description as description',
          $this->db_prefix.'meta_keys as meta_keys',
          $this->db_prefix.'meta_desc as meta_desc',
          $this->db_prefix.'meta_title as meta_title'
        )
        ->where(['id'=>$alias, 'Block'=>0])
        ->get()
      )->first();
      if($res):
        $this->page->meta_keys = $res->meta_keys;
        $this->page->meta_desc = $res->meta_desc;
        $this->page->meta_title = $res->meta_title;
        $res->directions = DB::select(
          "SELECT C.id,
          C.".$this->db_prefix."name as name
          FROM osc_pcatecories AS C
          WHERE C.block=0
          AND C.id IN (SELECT category_id FROM osc_producers_categories WHERE producer_id = $res->Id)"
        );
      endif;
      return $res;
    }

    public function getTeammates($support = false) {
      if($support):
        $res = DB::table('osc_page_about_team_list')
              ->select(
                'cover','languages','phone_1','phone_2','phone_3','fax',
                'email','fb_link','tw_link','ins_link','sk_link','in_link',
                $this->db_prefix.'name as name',
                $this->db_prefix.'position as position'
                )
              ->where(['block'=>0, 'support'=>1])
              ->get();
      else:
        $res[] = DB::table('osc_page_about_team_list')
              ->select(
                'cover','languages','phone_1','phone_2','phone_3','fax',
                'email','fb_link','tw_link','ins_link','sk_link','in_link',
                $this->db_prefix.'name as name',
                $this->db_prefix.'position as position'
                )
              ->where(['block'=>0, 'type'=>1])
              ->get();
        $res[] = DB::table('osc_page_about_team_list')
              ->select(
                'cover','languages','phone_1','phone_2','phone_3','fax',
                'email','fb_link','tw_link','ins_link','sk_link','in_link',
                $this->db_prefix.'name as name',
                $this->db_prefix.'position as position'
                )
              ->where(['block'=>0, 'type'=>2])
              ->get();
        endif;
      return $res;
    }

    public function getCompanyGallery() {
      $res = DB::table('osc_galleries')
              ->select('id', $this->db_prefix.'name as name', $this->db_prefix.'title as title')
              ->where(['block'=>0])
              ->get();
      foreach($res as $gallery):
        $gallery->images = DB::table('osc_files_ref')
          ->select('file','alt','title')
          ->where(['ref_id'=>$gallery->id,'ref_table'=>'gallery'])
          ->get();
        foreach($gallery->images as &$image) {
            $image->file = url('/public/img/gallery/'.$image->file);
        };
        $gallery->images = $this->cast_to_array($gallery->images);
      endforeach;
      return $res;
    }

    public function buildSitemap() {
      $categories = DB::select("SELECT id, news_list, producers_list, directions_list, ".$this->db_prefix."name as name FROM osc_menu_sitemap WHERE block = 0 ORDER BY order_id");
      foreach($categories as &$c):
        $c->nestings = DB::select(
          "SELECT menu.name, menu.alias
          FROM osc_menu menu
          LEFT JOIN osc_menu_sitemap_relations msr on msr.menu_id = menu.id
          WHERE msr.category_id = $c->id
          GROUP BY menu.alias"
        );
        if($c->news_list):
          $posts = DB::select("SELECT ".$this->db_prefix."name as name, alias FROM osc_articles WHERE block = 0");
          $c->nestings = (object)array_merge((array)$c->nestings, (array)$posts);
        endif;
        if($c->producers_list):
          $producers = DB::select("SELECT Name as name, CONCAT('/parts/', Id) as alias FROM osc_producers WHERE Block = 0");
          $c->nestings = (object)array_merge((array)$c->nestings, (array)$producers);
        endif;
        if($c->directions_list):
          $induscries = DB::select("SELECT name, '/parts/' as alias FROM osc_pcatecories");
          $c->nestings = (object)array_merge((array)$c->nestings, (array)$induscries);
        endif;
      endforeach;
      return $categories;
    }

    public function cast_to_array($object) {
      $o = [];
      foreach($object as $k => $v):
         if(strlen($k)):
           $o[$k] = is_object($v) ? $this->cast_to_array($v) : $v;
         endif;
      endforeach;
      return $o;
    }

    public function cast_to_object($array) {
      $o = new \stdClass;
      foreach($array as $k => $v):
         if(strlen($k)):
             $o->{$k} = is_array($v) ? $this->cast_to_object($v) : $v;
         endif;
      endforeach;
      return $o;
    }

    public function buildRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    public static function get_geo_location() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = (object)['country'=>null, 'city'=>null];
        if(filter_var($client, FILTER_VALIDATE_IP)):
            $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)):
            $ip = $forward;
        else:
            $ip = $remote;
        endif;
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
        if($ip_data && $ip_data->geoplugin_countryName != null):
            $result->country = strtolower($ip_data->geoplugin_countryCode);
            $result->city = strtolower($ip_data->geoplugin_city);
        endif;
        return $result;
    }

}
