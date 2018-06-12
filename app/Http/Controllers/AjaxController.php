<?php
namespace App\Http\Controllers;

use DB;
use App;
use Config;
use Cookie;
use Session;
use Response;
use Illuminate\Http\Request;
use App\Image;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\MailTemplates;

class AjaxController extends Controller
{
  private $responses;

  private function getMessage($code = '') {
    $response = $this->responses->where('code', (string)$code)->last();
    return $response ? $response->text : 'Error occured';
  }

  public function index( Request $request )
  {
    $this->responses = collect(DB::table('osc_page_ajax_responses')->select('code', $this->db_prefix.'text as text')->get());
    $res = ['status' => 'failed', 'message' => 'Something goes wrong'];

    if($request->has('a')):
      $act = $request->input('a');
      $gid = Session::get('guest');
      $uid = $gid;

      switch ($act) {
        case 'contact_message':
          $email = $request->input('e');
          $name = $request->input('n');
          $message = $request->input('m');
          $feedback = DB::table('osc_contact_form')->insertGetId([
            'email' => $email,
            'name' => $name,
            'message' => $message,
            'dateCreate' => date('Y-m-d H:i:s')
          ]);
          if($feedback):
            $res['status'] = 'success';
            $res['message'] = $this->getMessage('001');
          endif;
          break;

        case 'email_feedback':
          $email = $request->input('email');
          $message = $request->input('message');
          $captcha = $request->input('captcha');
          $captchaStored = Session::get('captcha');
          if($captcha == $captchaStored) {
            $feedback = DB::table('osc_contact_form')->insertGetId([
              'email' => $email,
              'message' => $message,
              'dateCreate' => date('Y-m-d H:i:s'),
              'type' => 1,
            ]);
            if($feedback):
              $res['status'] = 'success';
              $res['message'] = $this->getMessage('002');
            endif;
          } else {
            $res['message'] = $this->getMessage('003');
          }
          break;

        case 'load_order_chat':
          $filters = (object)[];
          $filters->sorting = (int)$request->input('sorting');
          $filters->order_id = (int)$request->input('ticket');
          $filters->page = $request->input('page') ? (int)$request->input('page') : 1;
          $chat = Order::get_chat($this->db_prefix, $filters);
          if($chat->list):
            $res['html'] = Order::build_chat_html($this->db_prefix, $chat->list);
            $res['pagi'] = Order::build_pagination($chat);
            $res['status'] = 'success';
            // $this->api->sendSeen($filters->order_id);
          endif;
        break;

        case 'send_ticket_message':
          $order_id = (int)$request->input('order');
          $message = $request->input('message');
          $user_id = (int)Session::get('user_id');
          $kunden_id = (int)Session::get('kunden_id');
          $entity = Order::where([ 'crm_id'=>$order_id, 'kunden_id'=>$kunden_id ])->first();
          if($entity):
            $message = Order::add_new_message(['order_id'=>$order_id, 'user_id'=>$user_id, 'message'=>$message]);
            if($message):
              Order::store_message_files($request->file('f'), $message);
              $res['status'] = 'success';
              $res['message'] = $this->getMessage('001');
              $this->api->sendMessage(Order::get_message($message));
            else:
              $res['message'] = $this->getMessage('001');
            endif;
          else:
            $res['message'] = $this->getMessage('001');
          endif;
        break;

        case 'password_recovery':
          $email = $request->input('email');
          $captcha = $request->input('captcha');
          $captchaStored = Session::get('captcha');
          if($captcha == $captchaStored) {
            if($user = $this->checkUserEmail($email)):
              $res['status'] = 'success';
              $res['message'] =  $this->getMessage('006');
              $newpass = $this->buildRandomString(10);
              DB::table('osc_users')->where(['id'=>$user->id])->update(['pass'=>md5($newpass)]);
              MailTemplates::build('password_recovery',$user->email,['password'=>$newpass], $this->db_prefix);
            else:
              $res['message'] =  $this->getMessage('004');
            endif;
          } else {
            $res['message'] =  $this->getMessage('005');
          }
          break;

        case 'password_change':
          $pass = $request->input('p');
          $newpass = $request->input('np');
          if($user = $this->checkUserPassword($pass)):
            $res['status'] = 'success';
            $res['message'] = $this->getMessage('008');
            DB::table('osc_users')->where(['id'=>$user->id])->update(['pass'=>md5($newpass)]);
            MailTemplates::build('password_changed',$user->email,['password'=>$newpass], $this->db_prefix);
          else:
            $res['message'] = $this->getMessage('007');
          endif;
          break;

        case 'auth':
          $email = $request->input('e');
          $pass = $request->input('p');
          if($user = $this->checkUser($email, $pass)):
            Session::put('user_id', $user);
            $res['status'] = 'success';
            $res['message'] = $this->getMessage('010');
          else:
            $res['message'] = $this->getMessage('009');
          endif;
          break;

        case 'register':
          $password = $request->input('pass');
          $user = [
            'type' => 9,
            'login' => $request->input('login'),
            'email' => $request->input('email'),
            'pass' => $request->input('pass'),
            'name' => $request->input('fname'),
            'fname' => $request->input('fname') ,
            'lname' => $request->input('lname'),
            'phone' => $request->input('phone'),
            'company' => $request->input('company'),
            'street' => $request->input('street'),
            'town' => $request->input('town'),
            'zip' => $request->input('zip'),
            'country' => $request->input('country'),
            'website' => $request->input('website'),
            'turnover' => $request->input('turnover'),
            'dateCreate' => date('Y-m-d H:i:s'),
          ];
          $captcha = $request->input('captcha');
          $captchaStored = Session::get('captcha');
          if($this->checkUser($user['login'])):
            $res['code'] = 101;
            $res['message'] = $this->getMessage('602');
          elseif ($captcha != $captchaStored):
              $res['code'] = 102;
              $res['message'] = $this->getMessage('612');
          else:
            $request = $this->api->syncSendUser($user);
            if(!$request['error']):
              $user['pass'] = strtoupper(md5($user['pass']));
              $user['KundenId'] = $request['KundenId'];
              $user_id = DB::table('osc_users')->insertGetId($user);
              $res['status'] = 'success';
              $res['message'] = $this->getMessage('613');
              MailTemplates::build('registration',$user['email'],['login'=>$user['login'],'password'=>$password], $this->db_prefix);
            else:
              $res['message'] = isset($request['status']) ? $this->getMessage($request['status']) : 'Service temporarily unavailable';
            endif;
            $res['request'] = $request;
          endif;
          break;

        case 'save_profile':
          $fname = $request->input('fname');
          $lname = $request->input('lname');
          $company = $request->input('company');
          $country = $request->input('country');
          $street = $request->input('street');
          $town = $request->input('town');
          $zip = $request->input('zip');
          $phone = $request->input('phone');
          $email = $request->input('email');
          $website = $request->input('website');
          $turnover = $request->input('turnover');
          $profile = $request->input('profile');
          $uid = Session::get('user_id');
          if($this->checkUserCredentials($uid)):
            $user = DB::table('osc_users')
            ->where(['id'=>$uid])
            ->update([
              'email' => $email,
              'name' => $fname,
              'fname' => $fname ,
              'lname' => $lname,
              'phone' => $phone,
              'company' => $company,
              'street' => $street,
              'town' => $town,
              'zip' => $zip,
              'country' => $country,
              'website' => $website,
              'turnover' => $turnover,
              'profile' => $profile,
            ]);
            $res['status'] = 'success';
            $res['message'] = $this->getMessage('014');
          else:
            $res['message'] = $this->getMessage('015');
          endif;
          break;

        case 'set_locale':
          $locale = $request->input('l');
          $locales = array_keys(Config::get('app.locales'));
          if(in_array($locale, $locales)):
            Session::put('set_locale', $locale);
            $res['status'] = 'success';
          endif;
          break;

        case 'search':
          $this->page = $this->setViewDescription('products');
          $query = $request->input('q');
          $products = $this->api->findProductsWithSync($query, ['Code']);
          $html = $this->buildSearchHtml($products, $query);
          $res['html'] = $html;
          $res['products'] = $products;
          $res['status'] = 'success';

        case 'to_cart':
          $id = (int)$request->input('p');
          $qty = (int)$request->input('q') ? (int)$request->input('q') : 1;
          $comment = $request->input('c') !== 'false' ? $request->input('c') : '';
          $vin = $request->input('v') !== 'false' ? $request->input('v') : '';
          $now = date('Y-m-d H:i:s');
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $product = $this->getProduct($id, $kunden_id);
          if($user_id && $product):
            $in_cart = DB::table('crm_cart')->where(['product_id'=>$id,'user_id'=>$user_id,'comment'=>$comment])->first();
            if($in_cart):
              DB::table('crm_cart')->where(['id'=>$in_cart->id])->update([
                'qty'=>($in_cart->qty + $qty),'price'=>$product->Price,
                'code'=>$product->Code,'comment'=>$comment,'vin'=>$vin
              ]);
            else:
              DB::table('crm_cart')->insert([
                'user_id'=>$user_id,'product_id'=>$id,'created'=>$now,
                'price'=>$product->Price,'code'=>$product->Code,
                'comment'=>$comment,'vin'=>$vin,'qty'=>$qty
              ]);
            endif;
            $res['status'] = 'success';
            $res['cart'] = $this->getUserCart();
          endif;
          break;

        case 'to_cart_pack':
          $products = $request->input('p'); 
          $now = date('Y-m-d H:i:s');
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $added = 0;
          foreach($products as $product):
            $id = $product['spare'];
            $qty = $product['qty'];
            $comment = $product['com'];
            $vin = $product['vin'];
            $product = $this->getProduct($id, $kunden_id);
            if($user_id && $product):
              $added += 1;
              $in_cart = DB::table('crm_cart')->where(['product_id'=>$id,'user_id'=>$user_id,'comment'=>$comment])->first();
              if($in_cart):
                DB::table('crm_cart')->where(['id'=>$in_cart->id])->update([
                  'qty'=>($in_cart->qty + $qty),'price'=>$product->Price,
                  'code'=>$product->Code,'comment'=>$comment,'vin'=>$vin
                ]);
              else:
                DB::table('crm_cart')->insert([
                  'user_id'=>$user_id,'product_id'=>$id,'created'=>$now,
                  'price'=>$product->Price,'code'=>$product->Code,
                  'comment'=>$comment,'vin'=>$vin,'qty'=>$qty
                ]);
              endif;
            endif;
          endforeach;
          $res['added'] = $added;
          $res['status'] = 'success';
          break;

        case 'get_replacement':
          $pid = (int)$request->input('p');
          $now = date('Y-m-d H:i:s');
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $products = $this->getSubstitution($pid, $kunden_id);
          if($user_id && $products):
            $this->page = $this->setViewDescription('cart');
            $res['content'] = $this->getSubstitutionContent($products);
            $res['status'] = 'success';
          endif;
          break;

        case 'cart_replacement':
          $sku = $request->input('s');
          $pid = (int)$request->input('p');
          $now = date('Y-m-d H:i:s');
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $substitution = collect(DB::select(
            "SELECT id FROM crm_products WHERE Code = (SELECT IF(AltCode = '$sku', AltCode, AltCode2) FROM crm_products WHERE id = $pid LIMIT 1)"
            ))->first();
          if($user_id && $substitution):
            $update = DB::table('crm_cart')
              ->where(['user_id'=>$user_id, 'product_id'=>$pid])
              ->update(['product_id'=>$substitution->id]);
            if($update) $res['status'] = 'success';
          endif;
          break;

        case 'update_qty':
          $id = (int)$request->input('p');
          $qty = (int)$request->input('q');
          $user_id = Session::get('user_id');
          $user_cart = DB::table('crm_cart')->where(['id'=>$id,'user_id'=>$user_id])->first();
          if($user_id && $user_cart):
            DB::table('crm_cart')->where(['id'=>$user_cart->id])->update(['qty'=>$qty]);
            $res['status'] = 'success';
            $res['price'] = number_format($user_cart->price, 2, ',', ' ');
            $res['amount'] = number_format($user_cart->price * $qty, 2, ',', ' ');
            $res['cart'] = $this->getUserCart();
          endif;
          break;

        case 'update_comment':
          $id = (int)$request->input('p');
          $comment = $request->input('q');
          $user_id = Session::get('user_id');
          $user_cart = DB::table('crm_cart')->where(['id'=>$id,'user_id'=>$user_id])->first();
          if($user_id && $user_cart):
            DB::table('crm_cart')->where(['id'=>$user_cart->id])->update(['comment'=>$comment]);
            $res['status'] = 'success';
          endif;
          break;

        case 'update_vin':
          $id = (int)$request->input('p');
          $vin = $request->input('q');
          $user_id = Session::get('user_id');
          $user_cart = DB::table('crm_cart')->where(['id'=>$id,'user_id'=>$user_id])->first();
          if($user_id && $user_cart):
            DB::table('crm_cart')->where(['id'=>$user_cart->id])->update(['vin'=>$vin]);
            $res['status'] = 'success';
          endif;
          break;

        case 'remove_from_cart':
          $id = (int)$request->input('p');
          $user_id = Session::get('user_id');
          $user_cart = DB::table('crm_cart')->where(['id'=>$id,'user_id'=>$user_id])->first();
          if($user_id && $user_cart):
            DB::table('crm_cart')->where(['id'=>$user_cart->id])->delete();
            $res['status'] = 'success';
            $res['cart'] = $this->getUserCart();
          endif;
          break;

        case 'clear_cart':
          $user_id = Session::get('user_id');
          $user_cart = DB::table('crm_cart')->where(['user_id'=>$user_id]);
          if($user_id && $user_cart):
            DB::table('crm_cart')->where(['user_id'=>$user_id])->delete();
            $res['status'] = 'success';
            $res['cart'] = $this->getUserCart();
          endif;
          break;

        case 'cart_import_finish':
          $user_id = Session::get('user_id');
          $products = $request->input('p') ? $request->input('p') : [];
          if($products):
            $producers = [];
            $matches_collected  = [];
            $matches_grouped = [];
            $dgroups = [];
            $results = [];
            $res['table'] = '';
            foreach($products as $group_id => $product):
              $mf = (int)$product['mf'] ? (int)$product['mf'] : false;
              $qty = (int)$product['qty'] ? (int)$product['qty'] : 1;
              $sku = $product['sku'];
              $com = $product['com'];
              $vin = $product['vin'];

              $matches = $this->api->findProductsNoSync($sku, ['Code'], $mf, true);
              $matches_found = sizeof($matches);

              if($matches_found == 1):
                foreach($matches as $product):
                  DB::table('crm_cart')->insert([
                    'product_id'=>$product->Id,
                    'price'=>$product->Price,
                    'code'=>$product->Code,
                    'comment'=>$com,
                    'vin'=>$vin,
                    'qty'=>$qty,
                    'user_id'=>$user_id,
                    'created'=>date('Y-m-d H:i:s'),
                  ]);
                endforeach;
              elseif($matches_found > 1):
                foreach($matches as &$product):
                  $product->mf  = $mf;
                  $product->qty = $qty;
                  $product->sku = $sku;
                  $product->com = $com;
                  $product->vin = $vin;
                  $results[] = $product;

                  if(!isset($producers[$product->ProducerId])):
                    $producers[$product->ProducerId] = ['name'=>$product->producer_name, 'logo'=>$product->producer_logo];
                  endif;
                  if(!isset($producers[$product->ProducerId]['suppliers'][$product->DGOwner])):
                    $producers[$product->ProducerId]['suppliers'][$product->DGOwner] = [];
                  endif;
                  $pool = (array)$product;
                  $producers[$product->ProducerId]['suppliers'][$product->DGOwner][] = $pool;
                  $matches_collected[] = $pool;
                endforeach;
              endif;  
            endforeach;

            usort($matches_collected, function($a,$b) { return $a['DGOwner'] > $b['DGOwner']; }); /* Сначала те у кого нет OwnerSupplierId */ 
            $seek_pair = function($product) use (&$matches_collected) {
              foreach($matches_collected as $i => $match):/* Пройдемся по всей коллекции  */
                if($match['Id'] == $product['Id']):       /* Да это тот же товар */ 
                    unset($matches_collected[$i]);        /* Удаляем из коллекции, он у нас уже есть */ 
                else:                                     /* А этот явно не такой */ 
                  if($match['Code'] == $product['Code']): /* Да и с таким же кодом */ 
                    if($match['DGOwner'] == $product['DGOwner'] && $match['DGOwner'] == 0): /* Но у обоих нет OwnerSupplierId */ 
                      unset($matches_collected[$i]);      /* Удалили найденного из коллекции и забыли */
                    elseif($match['DGOwner'] <> $product['DGOwner']): /* Ух ты, а этот с тем же кодом но другим OwnerSupplierId */ 
                      unset($matches_collected[$i]);      /* Удаляем первого из колекции */
                      return $match;                      /* Вернули его как пару нашему товару */
                    endif;
                  endif;
                endif;
              endforeach;
              return false;
            };

            foreach($producers as $p => $producer):
              usort($producer['suppliers'], function($a,$b) { return sizeof($a) < sizeof($b); });
              $matches_grouped[$p] = ['name'=>$producer['name'], 'logo'=>$producer['logo'], 'groups'=>[]];
              $producer_groups = &$matches_grouped[$p]['groups'];
              foreach($producer['suppliers'] as $supplier_id => $products):
                foreach($products as $product):
                  if(!in_array($product, $matches_collected)) continue;
                  if($pair = $seek_pair($product)):
                    $group_key = $product['DGOwner'] .'/'. $pair['DGOwner'];
                    if(!isset($producer_groups[$group_key])):
                      $producer_groups[$group_key][$product['DGOwner']] = ['name'=>$product['DGComment'], 'products'=>[$product]];
                      $producer_groups[$group_key][$pair['DGOwner']] = ['name'=>$pair['DGComment'], 'products'=>[$pair]];
                    else:
                      $producer_groups[$group_key][$product['DGOwner']]['products'][] = $product;
                      $producer_groups[$group_key][$pair['DGOwner']]['products'][] = $pair;
                    endif;
                  else:
                    DB::table('crm_cart')->insert([
                      'product_id'=>$product['Id'], 
                      'price'=>$product['Price'], 
                      'code'=>$product['Code'], 
                      'comment'=>$product['com'],
                      'vin'=>$product['vin'], 
                      'qty'=>$product['qty'], 
                      'user_id'=>$user_id, 
                      'created'=>date('Y-m-d H:i:s'),
                    ]);
                  endif;
                endforeach;
              endforeach;
              if(empty($producer_groups)) unset($matches_grouped[$p]);
            endforeach;

            $res['table'] = $this->buildImportFinishTable($matches_grouped);
            $res['groups'] = $matches_grouped;
            $res['status'] = 'success';
          else:
            $res['table'] = $this->buildImportFinishTable([]);
            $res['status'] = 'success';
          endif;
          break;

        case 'cart_import':
          $user_id = Session::get('user_id');
          $products = (array)$request->input('p');
          $is_order = (int)$request->input('o');
          $res['table'] = '';
          $res['matches'] = [];
          $res['matches_count'] = 0;
          $res['added_count'] = 0;
          $res['errors_count'] = 0;
          $skus = array_filter(array_column($products, 0));
          $sync_status = $this->api->findProductsSync($skus);
          if(is_array($products)):
            $this->page = $this->setViewDescription('import_modal');

            foreach($products as $group_id => $product):
              if(!isset($product[0])) continue;
              $product = array_map('trim', $product);
              $search_group = [];
              $search_group['predebugging'] = false;
              $search_group['debugging'] = false;
              $search_group['solved'] = false;
              $search_group['ordered'] = false;
              $search_group['mf'] = false;
              $search_group['id'] = $group_id;
              $search_group['sku'] = $product[0];
              if(isset($product[1]) && is_numeric($product[1])):
                $search_group['qty'] = isset($product[1]) ? (int)$product[1] : 1;
                $search_group['com'] = isset($product[2]) ? $product[2] : '';
                $search_group['vin'] = isset($product[3]) ? $product[3] : '';
              else:
                $search_group['mf'] = isset($product[1]) ? $product[1] : false;
                $search_group['qty'] = isset($product[2]) ? (int)$product[2] : 1;
                $search_group['com'] = isset($product[3]) ? $product[3] : '';
                $search_group['vin'] = isset($product[4]) ? $product[4] : '';
              endif;
              $search_group['matches'] = $this->api->findProductsNoSync($search_group['sku'], ['Code'], $search_group['mf'], true);
              $search_group['matches_found'] = sizeof($search_group['matches']);
              $search_group['matches_unique'] = [];

              if($search_group['matches_found'] == 1 && $search_group['qty'] > 0):
                $res['added_count'] += $search_group['matches_found'];
                $search_group['ordered'] = true;
                $search_group['solved'] = true;
                foreach($search_group['matches'] as $product):
                  DB::table('crm_cart')->insert([
                    'product_id'=>$product->Id,
                    'price'=>$product->Price,
                    'code'=>$product->Code,
                    'comment'=>$search_group['com'],
                    'vin'=>$search_group['vin'],
                    'qty'=>$search_group['qty'],
                    'user_id'=>$user_id,
                    'created'=>date('Y-m-d H:i:s'),
                  ]);
                endforeach;
              else:
                $search_group['debugging'] = true;
                $res['errors_count'] += 1;

                /* parse matches with unique manufacturer */
                $producer_id_prev = 0;
                foreach($search_group['matches'] as $product):
                  if($product->ProducerId != $producer_id_prev): 
                    $search_group['matches_unique'][] = $product;
                  endif;
                  $producer_id_prev = $product->ProducerId;
                endforeach;
                $search_group['matches_unique_found'] = sizeof($search_group['matches_unique']);
                // echo json_encode($search_group['matches_unique_found']) . "\n";
                /* parse matches with unique manufacturer */

                if(!$search_group['matches_unique_found'] || $search_group['matches_unique_found'] > 1 || $search_group['qty']==0):
                  $res['table'] .= $this->buildImportTable($search_group, $is_order);
                  $search_group['predebugging'] = true;
                endif;

                unset($search_group['matches']);
                unset($search_group['matches_unique']);
                $res['matches'][] = $search_group;

              endif;

              $res['matches_count'] += $search_group['matches_found'];
            endforeach;

            $res['message'] = $this->getMessage('016');
            $res['status'] = 'success';

          else:
            $res['message'] = $this->getMessage('017');
          endif;
          break;

        case 'create_order':
          $res['ordered'] = false;
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $comment = $request->has('c') && strlen(trim($request->input('c'))) ? $request->input('c') : null;
          $ignored = $request->has('i') ? $request->input('i') : null;
          $now = date('Y-m-d H:i:s');
          $user_cart = DB::table('crm_cart')->where(['user_id'=>$user_id])->get();
          if($user_id && $user_cart):
            $amount = $this->getUserCart();
            $can_order = $amount->ftotal <= $this->user->limit;
            $res['refill'] = number_format($amount->ftotal - $this->user->limit,2,',',' ');
            if($can_order):
              $entity = Order::create([
                'user_id'=>$user_id, 
                'kunden_id'=>$kunden_id, 
                'netto'=>0, 
                'brutto'=>0, 
                'created'=>$now, 
                'modified'=>$now, 
                'comment'=>$comment, 
                'ignored_products' => json_encode($ignored, JSON_HEX_APOS),
              ]);
              $order_id = $entity->id;
              if($order_id):
                foreach($user_cart as &$product):
                  unset($product->id);
                  $product->order_id = $order_id;
                  DB::table('crm_orders_products')->insert((array)$product);
                endforeach;
                DB::table('crm_cart')->where(['user_id'=>$user_id])->delete();
                /* sync */
                if(!$wb_number = $this->api->syncSendOrder($order_id)):
                  $entity->update(['wb_id' => 'WB'.substr(('00000' . $order_id), -5)]);
                endif;
                /* sync */
                $this->sendOrderEmail($order_id);
                $res['message'] = '<h1 style="text-align:center;">'.$this->getMessage('018').'</h1>';
                $res['ordered'] = true;
              endif;
            endif;
            $res['status'] = 'success';
          endif;
          break;

        case 'refresh_cart':
          $cart = $this->getUserCart(true);
          if($cart):
            $this->page = $this->setViewDescription('cart');
            $cart->table = $this->buildCartTable($cart);
            $res['cart'] = $cart;
            $res['status'] = 'success';
            $res['message'] = '';
          endif;
          break;

        case 'filter_orders':
          $start = date('Y-m-d', strtotime(implode('-', array_reverse(explode('.',$request->input('start'))))));
          $end = date('Y-m-d', strtotime(implode('-', array_reverse(explode('.',$request->input('end'))))));
          $code = $request->input('code');
          $keyword = $request->input('keyword');
          $orders = $this->getUserOrders($start, $end, $code, $keyword);
          $this->page = $this->setViewDescription('myorders');
          $res['table'] = $this->buildOrdersTable($orders);
          $res['status'] = 'success';
          $res['message'] = '';
          break;

        case 'remove_from_order':
          $id = (int)$request->input('p');
          $user_id = Session::get('user_id');
          $ordered_product = DB::table('crm_orders_products')->where(['id'=>$id,'user_id'=>$user_id])->first();
          if($user_id && $ordered_product):
            DB::table('crm_orders_products')->where(['id'=>$id])->update(['removed'=>1]);
            $res['status'] = 'success';
            $res['message'] = $this->getMessage('019');
            $res['order'] = $this->getOrderTotals($ordered_product->order_id);
          endif;
          break;

        case 'to_order':
          $user_id = Session::get('user_id');
          $kunden_id = $this->user->KundenId;
          $order_id = (int)$request->input('o');
          $id = (int)$request->input('p');
          $qty = (int)$request->input('q') ? (int)$request->input('q') : 1;
          $comment = $request->input('c') !== 'false' ? $request->input('c') : '';
          $vin = $request->input('v') !== 'false' ? $request->input('v') : '';
          $now = date('Y-m-d H:i:s');
          $product = $this->getProduct($id, $kunden_id);
          $order = DB::table('crm_orders')->where(['id'=>$order_id,'user_id'=>$user_id,'editable'=>1])->first();
          if($order && $user_id && $product):
            // $in_order = DB::table('crm_orders_products')->where(['product_id'=>$id,'order_id'=>$order_id])->first();
            // if($in_order):
            //   DB::table('crm_orders_products')->where(['id'=>$in_order->id])->update([
            //     'qty'=>($in_cart->qty + $qty),'price'=>$product->Price,
            //     'code'=>$product->Code,'comment'=>$comment,'vin'=>$vin
            //   ]);
            // else:
              $opid = DB::table('crm_orders_products')->insertGetId([
                'order_id' => $order_id,'user_id'=>$user_id,'product_id'=>$id,
                'created'=>$now,'price'=>$product->Price,'code'=>$product->Code,
                'comment'=>$comment,'vin'=>$vin,'qty'=>$qty
              ]);
              $product->id = $opid;
              $product->qty = $qty;
              $product->Price = $product->WsQty && $product->WsQty <= $qty ? $product->WsPrice * $product->Factor : $product->Price;
              $product->brutto_sum = $product->WsQty && $product->WsQty <= $qty ? $product->WsPrice * $product->Factor * $qty : $product->Price  * $qty;
              $product->comment = $comment;
              $product->in_stock = 0;
              $product->sent = 0;
            // endif;
            $this->page = $this->setViewDescription('myorder');
            $res['tr'] = $this->buildOrderTableRow($product);
            $res['order'] = $this->getOrderTotals($order_id);
            $res['status'] = 'success';
          endif;
          break;

        case 'remove_order':
          $user_id = Session::get('user_id');
          $order_id = (int)$request->input('o');
          $order = DB::table('crm_orders')->where(['id'=>$order_id,'user_id'=>$user_id, 'editable'=>1])->first();
          if($order):
            DB::table('crm_orders')->where(['id'=>$order_id])->update(['removed'=>1]);
            DB::table('crm_orders_products')->where(['order_id'=>$order_id])->update(['removed'=>1]);
            $res['status'] = 'success';
            $res['message'] = '<h4 class="title" style="font-size: 28px;text-align: center;">'.$this->getMessage('020').'</h4>';
          endif;
          break;

        default:
          break;
      }

    endif;
    return response()->json($res, 200);
  }

  public function logout() {
    $locale = Session::get('locale');
    Session::flush();
    Session::put('locale', $locale);
    return redirect()->route('home');
  }

  public function getSubstitutionContent($products) {
    ob_start();
    foreach($products as $product):
    ?>
    <div class="brand-info-container" style="padding-left:0;">
        <div class="logo-image"><img alt="<?= $product->producer_name ?>" src="<?= url('/public/img/icons-general/car-logos', $product->producer_logo) ?>"></div>
        <form class="product-overview">
            <h3 class="partcode-title"><small><?= $this->page->substitution_modal->text_2 ?></small> <?= $product->Code ?></h3>
            <table class="product-short-info">
                <tbody>
                    <tr>
                        <td><?= $this->page->substitution_modal->text_3 ?>: <br> <b> <?= strlen($product->producer_name) ? $product->producer_name : "&nbsp;" ?></b></td>
                    </tr>
                    <tr>
                        <td><?= $this->page->substitution_modal->text_4 ?>: <br> <b> <?= strlen($product->Details) ? $product->Details : "&nbsp;" ?></b></td>
                    </tr>
                    <tr>
                        <td><?= $this->page->substitution_modal->text_5 ?>: <br> <b> <?= strlen($product->Note) ? $product->Note : "&nbsp;" ?></b></td>
                    </tr>
                    <tr>
                        <td><?= $this->page->substitution_modal->text_6 ?>: <br> <b> <?= strlen($product->factor_group) ? $product->factor_group : "&nbsp;" ?></b></td>
                    </tr>
                    <tr>
                        <td><?= $this->page->substitution_modal->text_7 ?>: <br> <b> <?= strlen($product->discount) ? $product->discount : "&nbsp;" ?></b></td>
                    </tr>
                </tbody>
            </table>
            <div class="cart-footer-actions">
                <div class="total-amount">
                    <span class="text"><?= $this->page->substitution_modal->text_8 ?></span><span class="value"><?= number_format($product->brutto, 2, ',', ' ') ?></span>
                </div>
                <div class="action-buttons">
                    <button type="button" class="btn btn-red-small" onclick="__.cartReplacement(<?= $product->origin ?>, '<?= $product->Code ?>')"><?= $this->page->substitution_modal->text_9 ?></button>
                </div>
            </div>
        </form>
    </div>
    <?php
    endforeach;
    ?>
    <!-- <button type="button" class="btn btn-grey-small js_modal-close"><?= $this->page->substitution_modal->text_10 ?></button> -->
    <?php
    return ob_get_clean();
  }

  public function buildSearchHtml($products, $query) {
    ob_start();
    $producer_prev = null;
    ?>
    <p class="search-result-string"><b><?= sizeof($products) ?></b> <?= $this->page->text_5 ?> <b><?= $query ?></b></p>
    <div class="products-container tripple-container">
      <?php foreach($products as $p): ?>
        <?php if($p->producer_name != $producer_prev): ?>
          <h6 class="producer-separator"><span><?= $p->producer_name ?></span></h6>
        <?php $producer_prev = $p->producer_name; endif; ?>
        <div class="excerpt product-excerpt">
            <div class="header">
                <div class="logo-image"><img alt="<?= $p->producer_name ?>" src="<?= url('/public/img/icons-general/car-logos/' . $p->producer_logo) ?>"></div>
                <div class="info">
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_6 ?></span>
                        <span class="value"><?= $p->producer_name ?></span>
                    </div>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_7 ?></span>
                        <span class="value">
                          <?php if(SIGNEDIN): ?>
                          <a href="<?= url('/products', $p->Id) ?>" target="_blank">
                            <?= preg_replace('/('.$query.')/','<strong style="color: #c61619;">$1</strong>', $p->Code) ?>
                          </a>
                          <?php else: ?>
                            <?= preg_replace('/('.$query.')/','<strong style="color: #c61619;">$1</strong>', $p->Code) ?>
                          <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_10 ?></span>
                        <span class="value"><?= strlen(trim($p->AltCode)) ? $p->AltCode : '-' ?></span>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="info-block">
                    <span class="title"><?= $this->page->text_8 ?></span>
                    <span class="value"><?= $p->Details ?></span>
                </div>
                <?php if(SIGNEDIN): ?>
                  <div class="info-block">
                      <span class="title"><?= $this->page->text_12 ?></span>
                      <span class="value"><?= $p->factor_group ? $p->factor_group : '-' ?></span>
                  </div>
                <?php else: ?>
                <div class="info-block">
                    <span class="title"><?= $this->page->text_11 ?></span>
                    <span class="value"><?= $p->in_stock ?></span>
                </div>
                <?php endif; ?>
                <div class="info-block">
                    <span class="title"><?= $this->page->text_13 ?></span>
                    <span class="value"><?= $p->Weight ?> kg</span>
                </div>
            </div>
            <?php if(SIGNEDIN): ?>
            <div class="cart-footer-actions">
                <div class="total-amount">
                    <span class="text"><?= $p->user_price ? $this->page->text_18 : 'Price unavailable' ?></span>
                    <span class="value"><?= $p->user_price 
                    ? number_format($p->user_price, 2, ',', '') 
                    : '<a class="red js_modal-open" data-modal-type="email-feedback" data-modal-part="1">Contact</a> the manager for information.' 
                    ?></span>
                </div>
                <div class="total-amount">
                    <span class="text"></span><span class="value"><?= isset($p->Comment) ? $p->Comment : '' ?></span>
                </div>
                <div class="action-buttons">
                    <div class="btn counter-input js_counter-input">
                        <button type="button" class="counter-input__btn minus js_counter-input-btn"><span></span></button>
                        <input type="text" name="product-counter" value="1" class="input-quantity">
                        <button type="button" class="counter-input__btn plus js_counter-input-btn"><span></span></button>
                    </div>
                    <button type="button" class="btn btn-red" onclick="__.toCart(<?= $p->Id ?>, parseInt($(this).siblings().find('.input-quantity').val()))"><?= $this->page->text_19 ?></button>
                </div>
            </div>
            <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if(SIGNEDIN): ?>
    <div class="btn-container-general">
        <a href="<?=  url('/cart') ?>" class="btn btn-red btn-red-regular"><?= $this->page->text_20 ?></a>
    </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
  }

  public function buildSearchHtmlColumns($products, $query) {
    ob_start();
    ?>
    <p class="search-result-string"><b><?= sizeof($products) ?></b> <?= $this->page->text_5 ?> <b><?= $query ?></b></p>
    <div class="products-container tripple-container">
      <?php foreach($products as $p): ?>
        <div class="excerpt product-excerpt">
            <div class="header">
                <div class="logo-image"><img alt="" src="<?= url('/public/img/icons-general/car-logos/', $p->producer_logo) ?>"></div>
                <div class="info">
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_6 ?></span>
                        <span class="value"><?= $p->producer_name ?></span>
                    </div>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_7 ?></span>
                        <span class="value">
                          <?php if(SIGNEDIN): ?>
                          <a href="<?= url('/products', $p->Id) ?>" target="_blank">
                            <?= preg_replace('/('.$query.')/','<strong style="color: #c61619;">$1</strong>', $p->Code) ?>
                          </a>
                          <?php else: ?>
                            <?= preg_replace('/('.$query.')/','<strong style="color: #c61619;">$1</strong>', $p->Code) ?>
                          <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="col">
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_8 ?></span>
                        <span class="value"><?= $p->Details ?></span>
                    </div>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_9 ?></span>
                        <span class="value"><?= strlen(trim($p->AltCode)) ? 'Outdated' : 'Up-to-date' ?></span>
                    </div>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_10 ?></span>
                        <span class="value"><?= strlen(trim($p->AltCode)) ? $p->AltCode : '-' ?></span>
                    </div>
                    <?php if(SIGNEDIN): ?>
                      <div class="info-block">
                          <span class="title"><?= $this->page->text_11 ?></span>
                          <span class="value"><?= $p->in_stock ?></span>
                      </div>
                      <div class="info-block">
                          <span class="title"><?= $this->page->text_12 ?></span>
                          <span class="value"><?= $p->factor_group ? $p->factor_group : '-' ?></span>
                      </div>
                    <?php else: ?>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_14 ?></span>
                        <span class="value"> - <?php number_format($p->netto, '2', ',', '') ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if(SIGNEDIN): ?>
                <div class="col">
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_13 ?></span>
                        <span class="value"><?= $p->Weight ?> kg</span>
                    </div>
                    <?php if($p->factor < 1 && $p->factor_visibility): ?>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_14 ?></span>
                        <span class="value"><?= number_format($p->netto, '2', ',', '') ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(false): ?>
                    <div class="info-block">
                        <span class="title"><?= $this->page->text_15 ?></span>
                        <span class="value"><?= $p->factor < 1 && $p->factor_visibility ? (100 - ($p->factor * 100)).'%' : '-'; ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="info-block">
                        <span class="title"><?= $p->brutto ? $this->page->text_16 : 'Price unavailable' ?></span>
                        <span class="value"><?= $p->brutto 
                        ? number_format($p->brutto, '2', ',', '') 
                        : '<a class="red js_modal-open" data-modal-type="email-feedback" data-modal-part="1">Contact</a> the manager for information.' 
                        ?></span>
                    </div>
                </div>
              <?php endif; ?>
            </div>
            <?php if(SIGNEDIN): ?>
            <div class="cart-footer-actions">
                <div class="total-amount">
                    <span class="text"></span><span class="value">comment</span>
                </div>
                <div class="total-amount">
                    <span class="text"><?= $this->page->text_18 ?></span><span class="value"><?= number_format($p->brutto, '2', ',', '') ?></span>
                </div>
                <div class="action-buttons">
                    <div class="btn counter-input js_counter-input">
                        <button type="button" class="counter-input__btn minus js_counter-input-btn"><span></span></button>
                        <input type="text" name="product-counter" value="1" class="input-quantity">
                        <button type="button" class="counter-input__btn plus js_counter-input-btn"><span></span></button>
                    </div>
                    <button type="button" class="btn btn-red" onclick="__.toCart(<?= $p->Id ?>, parseInt($(this).siblings().find('.input-quantity').val()))"><?= $this->page->text_19 ?></button>
                </div>
            </div>
            <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if(SIGNEDIN): ?>
    <div class="btn-container-general">
        <a href="<?=  url('/cart') ?>" class="btn btn-red btn-red-regular"><?= $this->page->text_20 ?></a>
    </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
  }

  public function buildOrderTableRow($product) {
    ob_start();
    ?>
    <tr data-partcode="<?=  $product->Code ?>">
        <td class="cell-order-number" data-sort="1">
            <div class="title-mobile"><span class="text">№</span></div>
            <div class="cell-value"><b>1</b></div>
        </td>
        <td class="cell-order-partcode" data-sort="<?=  $product->Code ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_13 ?></span></div>
            <div class="cell-value"><b><?=  $product->Code ?></b></div>
        </td>
        <td class="cell-order-title" data-sort="<?=  $product->Details ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_14 ?></span></div>
            <div class="cell-value"><?=  $product->Details ?></div>
        </td>
        <td class="cell-order-discount" data-sort="<?=  $product->ClientDiscountGroupId ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_15 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->ClientDiscountGroupId ?></span></div>
        </td>
        <?php /* ?>
        <td class="cell-netto-price" data-sort="<?=  $product->OriginPrice ?>">
            <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_16 ?></span></span></div>
            <div class="cell-value"><span class="nowrap"><?=  sprintf('%.2f', $product->OriginPrice) ?></span></div>
        </td>
        <?php */ ?>
        <td class="cell-order-factor" data-sort="<?=  $product->Factor ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_17 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->discount ?></span></div>
        </td>
        <td class="cell-brutto-price" data-sort="<?=  $product->Price ?>">
            <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_18 ?></span></span></div>
            <div class="cell-value"><span class="nowrap"><?=  sprintf('%.2f', $product->Price) ?></span></div>
        </td>
        <td class="cell-order-quantity" data-sort="<?=  $product->qty ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_19 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->qty ?></span></div>
        </td>
        <td class="cell-sum" data-sort="<?=  $product->brutto_sum ?>">
            <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_20 ?></span></span></div>
            <div class="cell-value"><span class="nowrap"><?=  sprintf('%.2f', $product->brutto_sum) ?></span></div>
        </td>
        <td class="cell-comments-count" data-sort="<?=  $product->comment ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_21 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->comment ?></span></div>
        </td>
        <td class="cell-in-stock <?= !$product->in_stock ? 'status-waiting' : ( $product->in_stock < $product->qty ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?=  $product->in_stock ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_22 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->in_stock ?></span></div>
        </td>
        <td class="cell-sent <?= !$product->sent ? 'status-waiting' : ( $product->sent < $product->qty ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?=  $product->sent ?>">
            <div class="title-mobile"><span class="text"><?= $this->page->text_23 ?></span></div>
            <div class="cell-value"><span class="nowrap"><?=  $product->sent ?></span></div>
        </td>
        <td class="cell-delete">
            <div class="title-mobile"><span class="text"></span></div>
            <div class="cell-value"><button type="button" class="btn btn-delete icon icon-trash" onclick="__.removeFromOrder(<?=  $product->id ?>, event)"></button></div>
        </td>
        <td class="cell-watch">
            <div class="title-mobile"><span class="text"></span></div>
            <div class="cell-value"><button type="button" class="btn btn-table-icon-plus js_btn-order-details"></button></div>
        </td>
    </tr>
    <tr class="row-details">
        <td colspan="14">
          <div class="extended-details">
            <div class="extended-header">
                <div class="col">
                  <div class="extended-header__text">
                    <p style="text-align: center;"> - </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </td>
    </tr>
    <?php
    return ob_get_clean();
  }

  public function buildOrdersTable($orders) {
    ob_start();
    if(!empty($orders)):
    foreach($orders as $np => $order):
    ?>
      <tr>
          <td class="cell-number" data-sort="<?= $np + 1 ?>">
              <div class="title-mobile"><span class="text">№</span></div>
              <div class="cell-value"><b><?= $np + 1 ?></b></div>
          </td>
          <?php /* <td class="cell-client-code" data-sort="<?= $order->KundenCode ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_7 ?></span></div>
              <div class="cell-value"><?= $order->KundenCode ?></div>
          </td> */?>
          <td class="cell-order" data-sort="<?= $order->wb_id ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_8 ?></span></div>
              <div class="cell-value"><a href="<?= url('/profile/orders/'.$order->id) ?>" class="order-link link-blue"><b><?= strlen($order->wb_id) ? $order->wb_id : '-'  ?></b></a></div>
          </td>
          <td class="cell-status" data-sort="<?= $order->status ?>">
              <div class="title-mobile"><span class="text">Status</span></div>
              <div class="cell-value"><?= $order->status_name ?></div>
          </td>
          <td class="cell-products" data-sort="<?= $order->products ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_9 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= $order->products ?></span></div>
          </td>
          <td class="cell-date" data-sort="<?= strtotime($order->created) ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_11 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= date('d.m.Y H:i', strtotime($order->created)) ?></span></div>
          </td>
          <?php /* <td class="cell-netto-price" data-sort="<?= sprintf('%.2f', $order->netto) ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_12 ?></span></span></div>
              <div class="cell-value"><span class="nowrap"><?= sprintf("%.2f", $order->netto) ?></span></div>
          </td> */ ?>
          <td class="cell-brutto-price" data-sort="<?= sprintf('%.2f', $order->brutto) ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_13 ?></span></span></div>
              <div class="cell-value"><span class="nowrap"><?= sprintf("%.2f", $order->brutto) ?></span></div>
          </td>
          <td class="cell-vat" data-sort="<?= sprintf('%.2f', $order->vat) ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_14 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= sprintf("%.2f", $order->vat) ?>%</span></div>
          </td>
          <td class="cell-sum" data-sort="<?= sprintf('%.2f', $order->brutto) ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_15 ?></span></span></div>
              <div class="cell-value"><span class="nowrap"><b><?= sprintf("%.2f", ( $order->brutto + ($order->brutto/100*$order->vat) ) ) ?></b></span></div>
          </td>
          <td class="cell-in-stock <?= !$order->instock ? 'status-waiting' : ( $order->instock < $order->products ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?= $order->instock ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_16 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= $order->instock ?></span></div>
          </td>
          <td class="cell-sent <?= !$order->sent ? 'status-waiting' : ( $order->sent < $order->products ? 'status-in-progress' : 'status-complete' ) ?>" data-sort="<?= $order->sent ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_17 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= $order->sent ?></span></div>
          </td>
          <td class="cell-watch">
              <div class="title-mobile"><span class="text"></span></div>
              <div class="cell-value"><a href="<?= url('/profile/orders/'.$order->id) ?>" class="btn btn-watch icon icon-eye"></a></div>
          </td>
      </tr>
    <?php
    endforeach;
    else:
    ?>
      <tr>
        <td class="cell-watch" colspan="13">
          <div class="cell-value">
            <h4><?= $this->page->text_18 ?></h4>
          </div>
        </td>
      </tr>
    <?php
    endif;
    return ob_get_clean();
  }

  public function buildCartTable($cart) {
    ob_start();
    foreach($cart->products as $on => $p): ?>
      <tr data-product="<?= $p->id ?>">
          <td class="cell-number" data-sort="<?= $on+1 ?>">
              <div class="title-mobile"><span class="text">№</span></div>
              <div class="cell-value"><?= $on+1 ?></div>
          </td>
          <td class="cell-logo" data-sort="<?= $p->producer_name ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_5 ?></span></div>
              <div class="cell-value">
                <div class="logo-image">
                  <?php if(!$p->not_found): ?>
                  <img alt="<?= $p->producer_name ?>" title="<?= $p->producer_name ?>" src="<?= url('/public/img/icons-general/car-logos/'.$p->producer_logo) ?>">
                  <?php endif; ?>
                </div>
              </div>
          </td>
          <td class="cell-partcode" data-sort="<?= $p->Code ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_6 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= $p->Code ?></span></div>
          </td>
          <td class="cell-title" data-sort="<?= $p->Details ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_7 ?></span></div>
              <div class="cell-value"><b><?= $p->Details ?></b></div>
          </td>
          <td class="cell-discount" data-sort="<?= $p->FactorGroup ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_8 ?></span></div>
              <?= $p->FactorGroup ?><div class="cell-value"><span class="nowrap"><?= $p->FactorGroup ?></span></div>
          </td>
          <?php /* ?>
          <td class="cell-price" data-sort="<?= number_format($p->OriginPrice,2,',','') ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_9 ?></span></span></div>
              <div class="cell-value"><span class="nowrap"><?= number_format($p->OriginPrice,2,',','') ?></span></div>
          </td>
          <td class="cell-factor" data-sort="<?= $p->discount ?>">
              <div class="title-mobile"><span class="text"><?= $this->page->text_10 ?></span></div>
              <div class="cell-value"><span class="nowrap"><?= $p->discount ?></span></div>
          </td>
          <?php */ ?>
          <td class="cell-factor-price" data-sort="<?= number_format($p->Price,2,',',' ') ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_11 ?></span></span></div>
              <div class="cell-value"><span class="nowrap"><?= number_format($p->Price,2,',',' ') ?></span></div>
          </td>
          <td class="cell-quantity" data-sort="<?= $p->qty ?>"><div class="title-mobile"><span class="text"><?= $this->page->text_12 ?></span></div>
              <div class="cell-value"><input type="text" class="input-quantity" value="<?= $p->qty ?>" onchange="__.updateQty(<?= $p->id ?>, event)"></div>
          </td>
          <td class="cell-total" data-sort="<?= number_format($p->Price * $p->qty,2,',',' ') ?>">
              <div class="title-mobile"><span class="text"><span class="price"><?= $this->page->text_13 ?></span></span></div>
              <?= number_format($p->Price * $p->qty,2,',',' ') ?><div class="cell-value"><span class="nowrap"><b><?= number_format($p->Price * $p->qty,2,',',' ') ?></b></span></div>
          </td>
          <td class="cell-comment js_editable-cell" data-cell="cell-comment">
              <div class="title-mobile"><span class="text"><?= $this->page->text_14 ?></span></div>
              <div class="editable-block js_editable">
                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?= $p->comment ?></span></div>
                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateComment(<?= $p->id ?>, event)"></textarea></div>
              </div>
          </td>
          <td class="cell-vin js_editable-cell" data-cell="cell-vin">
              <div class="title-mobile"><span class="text"><?= $this->page->text_15 ?></span></div>
              <div class="editable-block js_editable">
                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?= $p->vin ?></span></div>
                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea" onchange="__.updateVin(<?= $p->id ?>, event)"></textarea></div>
              </div>
          </td>
          <td class="cell-delete">
            <?php if(strlen(trim($p->AltCode)) && !$p->not_found): ?>
              <div class="title-mobile"><span class="text"></span></div>
              <div class="cell-value"><button type="button" class="btn btn-delete icon icon-refresh" data-idx="<?= $p->product_id ?>" onclick="__.cartReplacementPopup(event)"></button></div>
            <?php endif; ?>
          </td>
          <td class="cell-delete">
              <div class="title-mobile"><span class="text"></span></div>
              <div class="cell-value"><button type="button" class="btn btn-delete icon icon-trash" data-idx="<?= $p->id ?>" onclick="__.removeFromCartPopup(event)"></button></div>
          </td>
      </tr>
    <?php
    endforeach;
    return ob_get_clean();
  }

  public function buildImportTable($group, $isOrder) {
    ob_start(); 
    ?>
      <tr class="matches-pre-debugging" data-solution="<?= $group['id'] ?>">
        <td class="cell-i-manuf">
            <div class="title-mobile"><span class="text">Manuf.</span></div>
            <div class="cell-value">
              <?php if($group['matches_unique_found'] == 1): ?>
                <div class="dpd disabled">
                    <div class="dpd-field">
                        <div class="dpd-field-input">
                            <span class="val js_dropdown-val"><?= end($group['matches_unique'])->producer_name ?></span>
                        </div>
                    </div>
                </div>                
              <?php elseif($group['matches_unique_found'] > 1): ?>
                <div class="dpd js_dropdown">
                    <div class="dpd-field">
                        <div class="dpd-field-input">
                            <span class="val js_dropdown-val">Select</span>
                            <input type="text" class="js_dropdown-input" name="maker" value="">
                        </div>
                    </div>
                    <div class="dpd-ct"><ul>
                          <?php foreach($group['matches_unique'] as $product): ?>
                            <li><a href="javascript:void(0)" class="js_dropdown-option" data-val="<?= $product->ProducerId ?>"><?= $product->producer_name ?></a></li>
                          <?php endforeach; ?>
                    </ul></div>
                </div>
              <?php endif; ?>
            </div>
        </td>
        <td class="cell-partcode" data-sort="10001">
            <div class="title-mobile"><span class="text">Partcode</span></div>
            <div class="cell-value">
                <div class="inp-btn">
                    <input type="text" class="input-partcode" name="sku" value="<?= $group['sku'] ?>">
                    <button type="button" class="btn btn-inp-prc icon icon-arrows-circle2 sku_trigger <?= !$group['matches_unique_found'] ? 'active' : '' ?>"></button>
                </div>
            </div>
        </td>
        <td class="cell-quantity" data-sort="9">
            <div class="title-mobile"><span class="text">Quant.</span></div>
            <div class="cell-value">
                <div class="inp-btn">
                    <input type="text" class="input-quantity" name="qty" value="<?= $group['qty'] ?>">
                    <button type="button" class="btn btn-inp-prc icon icon-arrows-circle2 qty_trigger active"></button>
                </div>
            </div>
        </td>
        <td class="cell-comment" data-cell="cell-comment">
            <div class="title-mobile"><span class="text">Comment.</span></div>
            <div class="editable-block">
                <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?= $group['com'] ?></span></div>
                <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea"><?= $group['com'] ?></textarea></div>
            </div>
        </td>
        <td class="cell-error" data-sort="Quantity is undefined">
            <div class="title-mobile"><span class="text">Message</span></div>
            <div class="cell-value">
                <div class="i-errors">
                    <div class="i-errors-ct">
                        <span class="error js_i-error error-partcode <?= !$group['matches_found'] ? 'active' : '' ?>">Part not found</span>
                        <span class="error js_i-error error-producer <?= $group['matches_unique_found'] > 1 ? 'active' : '' ?>">Choose a manufacturer</span>
                        <span class="error js_i-error error-quantity <?= !$group['qty'] ? 'active' : '' ?>">Quantity is undefined</span>
                    </div>
                    <div class="i-loader-ct">
                        <img src="assets/img/icons-general/arrows-circle-blue.svg" alt="">
                    </div>
                </div>
            </div>
        </td>
        <td class="cell-i-actions">
            <div class="title-mobile"><span class="text">Actions</span></div>
            <div class="cell-value">
                <div class="i-actions-btns">
                    <button type="button" class="btn btn-i-apply icon icon-checkmark4"></button>
                    <button type="button" class="btn btn-i-delete icon icon-cross3 active"></button>
                </div>
            </div>
        </td>
      </tr>
    <?php
    return ob_get_clean();
  }

  private function buildImportFinishTable($producers) {
    ob_start(); 
    if(sizeof($producers)):
    foreach($producers as $pi => $producer):
    ?>
      <div class="i-brand">
          <header class="i-brand__header">
              <h3 class="title">
                <div class="logo-image"><img class="mCS_img_loaded" 
                  alt="<?= $producer['name'] ?>" 
                  src="<?= url('/public/img/icons-general/car-logos/' . $producer['logo']) ?>"></div>
                <span class="text"><?= $producer['name'] ?></span>
              </h3>
          </header>

          <?php foreach(array_values($producer['groups']) as $gk => $group): ?>
          <div class="i-brand__block">

              <div class="form-style form-style--dark">
                  <div class="form-footer">
                      <div class="form-message icon icon-success message-success">
                          <span class="i-brand-msg-quanity">0</span> Items imported successfully.
                      </div>
                  </div>
              </div>

              <div class="form-tabs-2 js_tabs-scope" data-tabs="<?= $gk ?>">
                  <div class="form-tabs-2__nav">
                    <?php usort($group, function($a,$b) { return strcmp($b['name'], $a['name']); });  ?>
                    <?php foreach($group as $sk => $supplier): ?>
                      <button type="button" class="btn btn-tab js_tabs-trigger <?= !$sk ? 'active' : '' ?>" data-tabs="<?= $gk ?>" data-tab="<?= $sk ?>">
                          <span class="btn-content"><?= $supplier['name'] ? $supplier['name'] : 'Check with the manager' ?></span>
                      </button>
                    <?php endforeach; ?>
                  </div>
                  <div class="form-tabs-2__container">

                    <?php foreach($group as $sk => $supplier): ?>
                      <div class="tab js_tabs-target table-import-tab <?= !$sk ? 'active' : '' ?>" data-tabs="<?= $gk ?>" data-tab="<?= $sk ?>">
                          <div class="cart-table-container">
                              <table class="table-style-black table-import-result table-import-result--compare">
                                  <thead>
                                      <tr>
                                          <td class="cell-partcode">Partcode</td>
                                          <td class="cell-discount">Disc.gr.</td>
                                          <td class="cell-comment">Com.</td>
                                          <td class="cell-comment">Descr.</td>
                                          <td class="cell-price"><span class="price">Price<span class="currency">€</span></span></td>
                                          <td class="cell-add">Add to Cart</td>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($supplier['products'] as $product): $product = (object)$product; ?>
                                      <tr class="import-finish-row" data-spare="<?= $product->Id ?>" data-sku="<?= $product->Code ?>" data-qty="<?= $product->qty ?>" data-vin="<?= $product->vin ?>"  data-com="<?= $product->com ?>" data-delivery="<?= $product->DGOwner ?>">
                                          <td class="cell-partcode">
                                              <div class="title-mobile"><span class="text">Partcode</span></div>
                                              <div class="cell-value">
                                                  <span class="nowrap"><?= $product->Code ?></span>
                                              </div>
                                          </td>
                                          <td class="cell-discount">
                                              <div class="title-mobile"><span class="text">Disc.gr.</span></div>
                                              <div class="cell-value"><?= $product->factor_group ?></div>
                                          </td>
                                          <td class="cell-comment" data-cell="cell-comment">
                                              <div class="title-mobile"><span class="text">Comment.</span></div>
                                              <div class="editable-block">
                                                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?= $product->com ?></span></div>
                                                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea"><?= $product->com ?></textarea></div>
                                              </div>
                                          </td>
                                          <td class="cell-comment">
                                              <div class="title-mobile"><span class="text">Descr.</span></div>
                                              <div class="editable-block">
                                                  <div class="editable-block__value js_editable-value-container"><span class="js_editable-value"><?= $product->Details ?></span></div>
                                                  <div class="editable-block__textarea js_editable-input"><textarea class="comment-textarea js_editable-textarea"><?= $product->Details ?></textarea></div>
                                              </div>
                                          </td>
                                          <td class="cell-price">
                                              <div class="title-mobile"><span class="text"><span class="price">Price<span class="currency">€</span></span></span></div>
                                              <div class="cell-value"><span class="nowrap"><?= number_format($product->user_price, 2, '.', ' ') ?></span></div>
                                          </td>
                                          <td class="cell-add">
                                              <div class="title-mobile"><span class="text">Add to Cart</span></div>
                                              <div class="cell-value"><button class="btn btn-table-reg btn-i-add import-finish-add">+ Add</button></div>
                                          </td>
                                      </tr>
                                    <?php endforeach; ?>
                                  </tbody>
                              </table>
                          </div>
                          <div class="i-brand-buy">
                              <button class="btn btn-i-brand-buy import-finish-add-all"><span class="icon"><span class="plus"></span></span>Add All to Cart</button>
                          </div>
                      </div>
                    <?php endforeach; ?>

                  </div>
              </div>

          </div>
          <?php endforeach; ?>
      </div>
    <?php
    endforeach;
    else:
      echo '<h3 style="text-align: center;font-size: 2em;color: #434242;">All imported</h3>';
    endif;
    return ob_get_clean();
  }

  public function captcha( Request $request ) {
    $width = 300;
    $height = 120;
    $font_size = 24;
    $codelengh = 4;
    $font = "public/captcha/fonts/PlAGuEdEaTH.ttf";

    $letters = array(0,1,2,3,4,5,6,7,8,9);

    $image = imagecreatetruecolor($width,$height);
    $bg = imagecolorallocate($image,44,44,44);
    imagefill($image,0,0,$bg);

    for($i=0;$i<$codelengh;$i++):
       $color = imagecolorallocate($image,144,144,144);
       $letter = $letters[rand(0,sizeof($letters)-1)];
       $size = rand($font_size*2-2,$font_size*2+2);
       $x = ($i+4)*$font_size + rand(0, 1);
       $y = (($height*2)/3) + rand(2,10);
       $code[] = $letter;
       imagettftext($image,$size,rand(-10,10),$x,$y,$color,$font,$letter);
    endfor;

    $code = implode("",$code);
    Session::put('captcha', $code);

    ob_start();
    imagegif($image);
    $buffer = ob_get_clean();
    imagedestroy($image);
    $response = Response::make($buffer);
    $response->header('Content-Type', 'image/png');
    return $response;

  }
}
