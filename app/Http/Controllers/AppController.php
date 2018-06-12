<?php
namespace App\Http\Controllers;

use DB;
use App;
use Response;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producer;
use App\Models\User;
use App\Models\Order;

class AppController extends Controller
{

    public function home()
    {
      $this->bodyclass[] = 'page-home';
      $banners = $this->getHomeBanners();
      $posts = $this->getHomeArticles();
      $producers = $this->getHomeProducers();
      parent::close();
      return view('home', [ 'banners' => $banners, 'posts' => $posts, 'producers' => $producers ]);
    }

    /* CATALOG */

    public function products(Request $req)
    {
      $query = $req->has('q') ? $req->input('q') : false;
      parent::close();
      return view('products', [ 'query'=>$query ]);
    }

    public function product($slug)
    {
      $product = $this->getProductByQuery($slug, 'Id');
      if(!$product) return redirect('/404');
      parent::close();
      return view('product', [ 'product' => $product ]);
    }

    public function parts()
    {
      $categories = $this->getProducersCategories();
      parent::close();
      return view('parts', [ 'categories' => $categories ]);
    }

    public function brand($alias)
    {
      $brand = $this->getProducerByAlias($alias);
      if(!$brand) redirect('/404');
      parent::close();
      return view('brand', [ 'brand' => $brand ]);
    }

    public function prices()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      $pricelists = $this->getPricelists();
      parent::close();
      return view('pricelists', [ 'pricelists' => $pricelists ]);
    }

    public function price($name)
    {
  		if(!SIGNEDIN) return redirect()->route('home');
  		$name = pathinfo($name, PATHINFO_FILENAME);
      $producer = $name;
  		$extension = '.xlsx';
      $filename = $name . date('-d-m-y-H-i-s') . $extension;
      $savepath = 'public/pricelists/' . $filename;
  		$products = $this->getClientPricelist($producer);

      if(empty($products)) return redirect('/404');

  		$writer = new \App\Libraries\XLSXWriter;
  		$worksheet = [];
      $writer->setTempDir('public/pricelists/');
  		$writer->setTitle('autobox24.com');
  		$writer->setSubject('autobox24.com');
  		$writer->setAuthor('autobox24.com');
  		$writer->setCompany('autobox24.com');
  		$writer->setDescription('autobox24.com ' . $producer . ' pricelist');
  		$writer->writeSheetHeader(
  			'Prices', [
  				'#'=>'string','Product'=>'string','Description'=>'string','Weight'=>'string','Sizes'=>'string','Discount Group'=>'string','Price, €'=>'string'
  			], [
  				'widths'=>[8,20,40,10,10,45,10], 'height'=>25, 'font-size'=>11, 'font-style'=>'bold',
  				'fill'=>'#eee', 'border'=>'top,bottom,left,right', 'halign'=>'center', 'valign'=>'center',
        ]
  		);
  		foreach($products as $idx => $product):
  			$styles = [['halign'=>'left'],['halign'=>'left'],['halign'=>'left'],['halign'=>'left'],['halign'=>'left'],['halign'=>'center'],['halign'=>'center']];
  			$worksheet[] = $row = [
  				$idx + 1,
  				$product->Code,
  				$product->Details,
  				$product->Weight ?: '',
  				$product->Sizes ?: '',
          		$product->factor_group,
  				number_format($product->user_price, 2, ',', ' '),
  			];
  			$writer->writeSheetRow('Prices', $row, $styles);
  		endforeach;
  		$writer->writeToFile($savepath);
      $buffer = file_get_contents($savepath);
  		unlink($savepath);
      $response = Response::make($buffer);
      $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $response->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
      return $response;
    }
    /* CATALOG */

    /* PROFILE */

    public function pricelists()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      $pricelists = $this->getPricelists();
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.pricelists', [ 'pricelists' => $pricelists ]);
    }

    public function cart()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      parent::close();
      $cart = $this->getUserCart(true);
      $cart->can_order = $cart->ftotal <= $this->user->deposit + $this->user->balance;
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.cart', [ 'cart'=>$cart ]);
    }

    public function balance()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      parent::close();
      $moneyflow = User::moneyflow();
      $invoices = User::invoices();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.balance', ['moneyflow'=>$moneyflow,'invoices'=>$invoices]);
    }

    public function security()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.security', [  ]);
    }

    public function settings()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      $user = $this->getUserData();
      $countries = DB::table('osc_countries')->select('id','name')->get();
      $profiles = ['Wholesale', 'Machine', 'Parts24'];
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.settings', [ 'user' => $user, 'countries'=>$countries, 'profiles'=>$profiles ]);
    }

    public function myorders() {
      if(!SIGNEDIN) return redirect()->route('home');
      $startDate = date('Y-m-d', strtotime('-1 month'));
      $endDate= date('Y-m-d');
      $orders = $this->getUserOrders($startDate, $endDate);
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.orders', ['orders'=>$orders, 'ordersEndDate' => $endDate, 'ordersStartDate' => $startDate ]);
    }

    public function myorder($id) {
      if(!SIGNEDIN || !$order = $this->getOrderDetails($id)) return redirect()->route('home');
      $chat = Order::get_chat($this->db_prefix, (object)['page'=>1, 'order_id'=>$order->crm_id]);
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.order', [ 'order' => $order, 'chat' => $chat ]);
    }

    public function discounts()
    {
      if(!SIGNEDIN) return redirect()->route('home');
      $discounts = $this->getUserDiscounts();
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      return view('profile.discounts', [ 'discounts' => $discounts ]);
    }

    public function payments() {
      if(!SIGNEDIN) return redirect()->route('home');
      parent::close();
      view()->share('_profilemenu', $this->getProfileMenu());
      dd([
        'refills' => User::get_refills($this->user->KundenId),
        'writeoffs' => User::get_writeoffs($this->user->KundenId)
      ]);
      return view('profile.payments', [
        'refills' => User::get_refills($this->user->KundenId),
        'writeoffs' => User::get_writeoffs($this->user->KundenId)
      ]);
    }

    /* PROFILE */

    /* NEWS */

    public function posts()
    {
      $tags = $this->getArticlesHashtages();
      $posts = $this->getArticles();
      parent::close();
      return view('posts', [ 'tags' => $tags, 'posts' => $posts ]);
    }

    public function post($alias)
    {
      $post = $this->getArticle($alias);
      if(empty($post)) redirect('/404');
      parent::close();
      return view('post', [ 'alias' => strtoupper($alias), 'post' => $post ]);
    }

    /* NEWS */

    /* CONTACTS */

    public function contactus() {
      $teammates = $this->getTeammates(true);
      parent::close();
      return view('contacts.contactus', [ 'teammates' => $teammates ]);
    }

    public function faq() {
      $tags = $this->getFaqsHashtages();
      $faqs = $this->getFaqs();
      parent::close();
      return view('contacts.faq', [ 'tags' => $tags, 'faqs' => $faqs ]);
    }

    public function contacts($view)
    {
      $template = 'contacts.'.$view;
      if(!view()->exists($template)) return redirect('/404/');
      $vars = [ 'viewname' => 'PAGE '.strtoupper($view) ];
      parent::close();
      return view($template, $vars);
    }

    public function sitemap()
    {
      $sitemap = $this->buildSitemap();
      parent::close();
      return view('contacts.sitemap', [ 'sitemap' => $sitemap ]);
    }

    /* CONTACTS */

    /* ABOUT US */

    public function about($view)
    {
      $template = 'about.'.$view;
      if(!view()->exists($template)) return redirect('/404/');
      $vars = [ 'viewname' => 'PAGE '.strtoupper($view) ];
      parent::close();
      return view($template, $vars);
    }

    public function team()
    {
      $teammates = $this->getTeammates();
      parent::close();
      return view('about.team', [ 'teammates' => $teammates ]);
    }

    public function benefits()
    {
      parent::close();
      return view('about.benefits', [  ]);
    }

    public function joinus()
    {
      parent::close();
      return view('about.join', [  ]);
    }

    public function companyprofile()
    {
      parent::close();
      return view('about.profile', [  ]);
    }

    public function certificates()
    {
      $certificates = $this->getCertificates();
      parent::close();
      return view('about.certificates', [ 'certificates' => $certificates ]);
    }

    public function gallery()
    {
      $gallery = $this->getCompanyGallery();
      parent::close();
      return view('about.gallery', [ 'gallery' => $gallery ]);
    }

    public function signup()
    {
      parent::close();
      return view('about.signup', [  ]);
    }

    public function whyus()
    {
      $producers = DB::table('osc_producers')->where('Block', 0)
      ->select('Name', 'Logo', 'Id')
      ->orderBy('Name')->get();
      $vars = [ 'producers' => $producers ];
      parent::close();
      return view('about.whyus', $vars);
    }

    /* ABOUT US */

    /* CONVENTIONS */

    public function terms() {
      parent::close();
      return view('conventions.terms');
    }

    public function legal() {
      parent::close();
      return view('conventions.legal');
    }

    public function privacy() {
      parent::close();
      return view('conventions.privacy');
    }

    public function returns() {
      parent::close();
      return view('conventions.returns');
    }

    public function shipping() {
      parent::close();
      return view('conventions.shipping');
    }

    public function secure() {
      parent::close();
      return view('conventions.secure');
    }

    public function guarantee() {
      parent::close();
      return view('conventions.guarantee');
    }

    /* CONVENTIONS */

    public function notfound()
    {
      parent::close();
      return view('errors.404', [  ]);
    }

    public function clean($string) {
       $string = str_replace([' ','-'], '_', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

}
