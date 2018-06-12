<?php
namespace App\Api;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Producer;
use App\Models\Product;
use App\Models\User;
use App\Models\DiscountGroup;
use App\Models\ClientDiscountGroup;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Events\MessageReceived;

class Provider extends MSSQL
{
  const api_auth_token = 'sakjdkasjdlkasjdjkasjdjgfg';
  const api_remote = 'http://195.238.187.196/'; 
  const api_new_message_url = self::api_remote . 'Silence/Conversation/talk';
  const api_seen_message_url = self::api_remote . 'Silence/Conversation/talkseen';
  const api_registration_url = self::api_remote . 'Silence/Entry/new_client';
  const api_orders_send_url = self::api_remote . 'Silence/Entry/new_wb';
  const api_orders_get_url = self::api_remote . 'Silence/Entry/sync_clients_orders';
  const api_orders_get_complete_url = self::api_remote . 'Silence/Entry/sync_clients_orders_success';
  const api_products_get_url = self::api_remote . 'Silence/Entry/sync_products';
  const api_products_get_complete_url = self::api_remote . 'Silence/Entry/sync_products_success';
  const api_producers_get_url = self::api_remote . 'Silence/Entry/sync_producers';
  const api_producers_get_complete_url = self::api_remote . 'Silence/Entry/sync_producers_success';
  const api_discount_groups_get_url = self::api_remote . 'Silence/Entry/request_changed_dgs';
  const api_discount_groups_by_producer_get_url = self::api_remote . 'Silence/Entry/get_dg_by_producer';
  const api_discounts_get_url = self::api_remote . 'Silence/Entry/request_changed_client_dgs';
  const api_user_discounts_get_url = self::api_remote . 'Silence/Entry/request_client_dgs';
  const api_products_find_url = self::api_remote . 'Silence/Entry/request_products';
  const api_users_sync_url = self::api_remote . 'Silence/Entry/sync_clients';
  const api_users_sync_complete_url = self::api_remote . 'Silence/Entry/sync_clients_success';
  const api_users_invoices_url = self::api_remote . 'Silence/Entry/sync_clients_invoices';
  const api_users_payments_url = self::api_remote . 'Silence/Entry/sync_clients_payments';
  


  const api_success = 200;
  const api_error = 403;
  const api_responses = [
    403 => 'Api error',
    500 => 'Connection not established',
    601 => 'Empty login',
    602 => 'User exists',
    603 => 'Empty password',
    604 => 'Empty name',
    605 => 'Empty lastname',
    606 => 'Empty company name',
    607 => 'Empty street',
    608 => 'Empty city',
    609 => 'Empty country',
    610 => 'Empty phone',
    611 => 'Empty email',
  ];

  public function __construct() {  }

  public function storeFiles(Request $request) {

    $response = (object)['status'=>'failed', 'error'=>null, 'files'=>null];
    $files = $request->file('files');

    $response->files = $files;
    $response->request = $request->all();
    $response->method = $request->method();
    $response->origins = [$_SERVER['REQUEST_METHOD'], $_GET, $_POST, $_FILES];

    if(strtolower($request->method()) <> 'post'):
      $response->error = 'method_not_allowed';
      return response()->json($response);
    endif;

    if($request->header('X-CSRF-TOKEN') <> self::api_auth_token): 
      $response->error = 'token_mismatch';
      return response()->json($response);
    endif;

    if(!$files):
      $response->error = 'nothing_to_store';
      return response()->json($response);
    endif;

    foreach($files as $file):
      $is_stored = Order::store_file($file);
      $response->files[] = ['name'=>$file->getClientOriginalName(), 'stored'=>$is_stored];
    endforeach;

    $response->status = 'ok';
    return response()->json($response, 200)->header('Access-Control-Allow-Headers', '_token');

  }

  public function sendSeen($order_id = 0) {
    if($order_id):
      $this->request(self::api_seen_message_url, ['order_id' => $order_id]);
    endif;
  }

  public function sendMessage($message = null) {
    if($message):
      $this->request(self::api_new_message_url, $message);
    endif;
  }

  public function storeMessage(Request $request) {

    $response = (object)['status'=>'failed', 'error'=>null, 'files'=>null];

    if(strtolower($request->method()) <> 'post'):
      $response->error = 'method_not_allowed';
      return response()->json($response);
    endif;

    if($request->header('X-CSRF-TOKEN') <> self::api_auth_token): 
      $response->error = 'token_mismatch';
      return response()->json($response);
    endif;

    $message = [
      'crm_id' => (int)$request->input('Id'),
      'order_id' => (int)$request->input('OrderId'),
      'user_name' => $request->input('SenderName'),
      'message' => $request->input('Message'),
      'is_admin' => 1,
    ];

    $message_id = DB::table('crm_tickets_messages')->insertGetId($message);
    if($message_id):
      event(new MessageReceived($message['order_id']));
      $files = $request->input('Filenames');
      $files = is_string($files) ? @json_decode($files, true) : $files;
      $files = @array_filter($files);
      if($files):
        $files_to_insert = [];
        foreach($files as $file):
          if($file && strlen(trim($file))):
            $files_to_insert[] = [
              'message_id' => $message_id,
              'file' => $file,
              'extension' => pathinfo($file, PATHINFO_EXTENSION),
            ];
          endif;
        endforeach;
        DB::table('crm_tickets_messages_files')->insert($files_to_insert);
      endif;
    endif;

    $response->status = 'ok';
    return response()->json($response, 200);

  }

  public function flushOrders() {
    Order::truncate();
    OrderProduct::truncate();
    dd('Orders cleared');
    exit();
  }

  public function flushClients() {
    User::where('type', 9)->delete();
    ClientDiscountGroup::truncate();
    Transaction::truncate();
    Invoice::truncate();
    dd('Clients cleared');
    exit();
  }

  public function syncGetProducts() {
    $req = $this->request(self::api_products_get_url);
    $changed = [];
    $products = $this->cast_to_object($req['body']);
    foreach($products as $product):
      $sync = $this->productUpdateOrInsert($product);
      if($sync) $changed[] = $sync;
    endforeach;
    $this->request(self::api_products_get_complete_url, [ 'updated'=>$changed ]);
    dd($req);
    exit();
  }

  public function syncGetProducers() {
    $now = date('Y-m-d H:i:s');
    $changed = [];
    $req = $this->request(self::api_producers_get_url);
    $producers = $req['body'] ?? null;
    if($producers && is_array($producers)):
      foreach($producers as $producer):
      	$producer = (object)$producer;
      	$producer->Id = $producer->Id ?? 0;
        if($producer->Id):
    			Producer::updateOrCreate([
    				'Id' => $producer->Id
    			],[
    				'Name' => $producer->Name,
    				'WebSync' => $producer->WebSync,
    				'WebModified' => $producer->WebModified,
    				'Deleted' => $producer->Deleted,
    				'Block' => $producer->Block,
    				'Created' => $producer->Created,
    				'Modified' => $now,
    				'CreatedUserId' => $producer->CreatedUserId,
    				'ModifiedUserId' => $producer->ModifiedUserId,
    				'IsVag' => $producer->IsVag,
    			]);
        	if($producer->Logo && strlen(trim($producer->Logo))):
        		$producer = Producer::where('Id', $producer->Id)->first();
            if($producer && strlen(trim($producer->Logo))):
              $source = self::api_remote . ltrim($producer->Logo, '/');
              $extension = pathinfo($source, PATHINFO_EXTENSION);
              $filename = time() . '.' . $extension;
              $storage = 'public/img/icons-general/car-logos/';
              $headers = @get_headers($source);
              if($headers[0] == "HTTP/1.1 200 OK" && copy($source, $storage . $filename)):
          			@unlink($storage . $producer->Logo);
          			$producer->update(['Logo' => $filename]);
          		endif;
            endif;
        	endif;
       	 	$changed[] = $producer->Id;
       	endif;
      endforeach;
      if($changed) $this->request(self::api_producers_get_complete_url, ['updated'=>$changed]);
    endif;
    dd($req);
    exit();
  }

  public function syncGetUserDiscounts($clients) {
    $clients = is_array($clients) ? $clients : [$clients];
    $req = $this->request(self::api_user_discounts_get_url, ['Clients'=>$clients]);
    $cgroups = $req['body']['ClientDgs'] ?? null;
    if($cgroups && is_array($cgroups)):
      $clients = array_unique(array_column($cgroups, 'ClientId'));
      ClientDiscountGroup::whereIn('ClientId', $clients)->delete();
      foreach($cgroups as $CDG):
        ClientDiscountGroup::create([
          'Id' => $CDG['Id'],
          'Name' => $CDG['Name'] ?? $CDG['DiscountGroupId'] ?? null,
          'ClientId' => $CDG['ClientId'],
          'DiscountGroupId' => $CDG['DiscountGroupId'],
          'Factor' => $CDG['Factor'],
          'Visibility' => (int)$CDG['DiscountVisibility'],
        ]);
      endforeach;
    endif;
    exit();
  }

  public function syncGetDiscounts() {
    $req = $this->request(self::api_discounts_get_url);
    $cgroups = $req['body']['ClientDgs'] ?? null;
    if($cgroups && is_array($cgroups) && !empty($cgroups)):
      $clients = array_unique(array_column($cgroups, 'ClientId'));
      ClientDiscountGroup::whereIn('ClientId', $clients)->delete();
      foreach($cgroups as $CDG):
        ClientDiscountGroup::create([
          'Id' => $CDG['Id'],
          'Name' => $CDG['Name'] ?? $CDG['DiscountGroupId'] ?? null,
          'ClientId' => $CDG['ClientId'],
          'DiscountGroupId' => $CDG['DiscountGroupId'],
          'Factor' => $CDG['Factor'],
          'Visibility' => (int)$CDG['DiscountVisibility'],
        ]);
      endforeach;
    endif;
    dd($req);
    exit();
  }

  public function syncGetDiscountGroups() {
    $req = $this->request(self::api_discount_groups_get_url);
    $groups = $req['body']['DiscountGroups'] ?? null;
    if($groups && is_array($groups)):
      foreach($groups as $DG):
      	if(!$DG['Id']) continue;
        DiscountGroup::updateOrCreate([
          'Id'=>$DG['Id'],
        ],[
	      'Name' => $DG['Name'] ?? null,
	      'Comment' => $DG['Comment'] ?? null,
	      'ProducerId' => $DG['ProducerId'] ?? 0,
	      'PrimarySupplierId' => $DG['PrimarySupplierId'] ?? 0,
	      'OwnerSupplierId' => $DG['OwnerSupplierId'] ?? 0,
	      'Deleted' => $DG['Deleted'] ?? 0,
	      'Block' => $DG['Blocked'] ?? 0,
        ]);
      endforeach;
    endif;
    dd($req);
    exit();
  }

  public function syncGetDiscountGroupsByProducer() {
    $producers = Producer::selectRaw("DISTINCT Id")->get();
    foreach($producers as $producer):
      if(!is_integer($producer->Id)) continue;

      $req = $this->request(self::api_discount_groups_by_producer_get_url, ['ProducerId'=>$producer->Id]);
      echo "\n ProducerId:$producer->Id " . json_encode($req) . "<br>";

      $groups = $req['body'] ?? null;
      if($groups && is_array($groups)):
      	DiscountGroup::where('ProducerId', $producer->Id)->delete();
        foreach($groups as $ggroup):
      	  $DG = $ggroup['discountGroups'];
      	  $DG['clientDiscountGroups'] = $ggroup['clientDiscountGroups'];
          $DG['ProducerId'] = $producer->Id;
          if(!$DG['Id']) continue;
          DiscountGroup::create([
          	'Id'=>$DG['Id'],
            'Name' => $DG['Name'] ?? null,
            'Comment' => $DG['Comment'] ?? null,
            'ProducerId' => $DG['ProducerId'] ?? 0,
            'PrimarySupplierId' => $DG['PrimarySupplierId'] ?? 0,
            'OwnerSupplierId' => $DG['OwnerSupplierId'] ?? 0,
            'Deleted' => $DG['Deleted'] ?? 0,
            'Block' => $DG['Blocked'] ?? 0,
          ]);
          $clientDGs = $DG['clientDiscountGroups'] ?? null;
          if($clientDGs && is_array($clientDGs) ):
            ClientDiscountGroup::where('DiscountGroupId', $DG['Id'])->delete();
            foreach($clientDGs as $clientDG):
              ClientDiscountGroup::create([
                'Id' => $clientDG['Id'] ?? 0,
                'Name' => $clientDG['Name'] ?? $clientDG['DiscountGroupId'] ?? null,
                'ClientId' => $clientDG['ClientId'] ?? 0,
                'DiscountGroupId' => $DG['Id'] ?? 0,
                'Factor' => $clientDG['Factor'] ?? 0,
                'Visibility' => $clientDG['DiscountVisibility'] ?? 1,
              ]);
            endforeach;
          endif;

        endforeach;
      endif;
    endforeach;
    exit();
  }

  public function syncSendOrders() {
    $orders = DB::table('crm_orders')->where('status','<','3')->get();
    foreach($orders as &$o):
      $o->netto = 0;
      $o->brutto = 0;
      $o->products = DB::select(
        "SELECT OP.id, OP.order_id, OP.user_id, OP.product_id, OP.code, OP.qty, OP.qty_ab,
        OP.in_stock, OP.sent, OP.comment, OP.comment_m, OP.vin, OP.status, OP.created, OP.modified, OP.removed,
        OP.price as cart_price,
        IF(P.Price, P.Price, 0) as price,
        IF(CDG.Factor, CDG.Factor, 0) as factor,
        IF(CDG.Factor, CDG.DiscountGroupId, 0) as discount_group_id,
        IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor * OP.qty, P.Price * CDG.Factor * OP.qty), 0) as netto_sum
        FROM crm_orders_products as OP
        LEFT JOIN crm_products as P on P.id = OP.product_id
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = $o->kunden_id)
        WHERE order_id = $o->id"
      );
      foreach($o->products as $p):
        $o->netto += $p->netto_sum;
      endforeach;
      $o->brutto = $o->netto + ( $o->netto / 100 * $o->vat );
      Order::where([
        'id'=>$o->id, 'origin_order_json'=>null
      ])->update([
        'origin_order_json' => json_encode($o, JSON_HEX_APOS)
      ]);
    endforeach;
    $orders = $this->cast_to_array($orders);
    $req = $this->request(self::api_orders_send_url, [ 'orders' => $orders ]);

    if(isset($req['body']) && !empty($req['body'])):
      foreach($req['body'] as $o):
        if(trim($o['Crm_Status']) == 'success'):
          $order = Order::where(['id'=>$o['Web_Id']])->orWhere(['crm_id'=>$o['WB_Id']])->first();
          $order->update([
            'crm_id' => $o['WB_Id'],
            'wb_id' => $o['Web_Number'],
            'netto' => $o['Netto_Sum'],
            'brutto' => $o['Brutto_Sum'],
            'vat' => $o['Mw_St'],
            'crm_status' => $o['Crm_Status'],
            'modified' => date('Y-m-d H:i:s'),
          ]);
        endif;
      endforeach;
    endif;
    dd($orders, $req);
    exit();
  }

  public function syncSendOrder($order_id) {
    $wb_number = 0;
    $orders = Order::where('id', $order_id)->get();
    foreach($orders as &$order):
      $order->netto = 0;
      $order->brutto = 0;
      $order->products = DB::select(
        "SELECT OP.id, OP.order_id, OP.user_id, OP.product_id, OP.code, OP.qty, OP.qty_ab,
        OP.in_stock, OP.sent, OP.comment, OP.comment_m, OP.vin, OP.status, OP.created, OP.modified, OP.removed,
        OP.price as cart_price,
        IF(P.Price, P.Price, 0) as price,
        IF(CDG.Factor, CDG.Factor, 0) as factor,
        IF(CDG.Factor, CDG.DiscountGroupId, 0) as discount_group_id,
        IF(CDG.Factor, IF(P.WsQty AND P.WsQty <= OP.qty, P.WsPrice * CDG.Factor * OP.qty, P.Price * CDG.Factor * OP.qty), 0) as netto_sum
        FROM crm_orders_products as OP
        LEFT JOIN crm_products as P on P.id = OP.product_id
        LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = $order->kunden_id)
        WHERE order_id = $order->id"
      );
      foreach($order->products as $p):
        $order->netto += $p->netto_sum;
      endforeach;
      $order->brutto = $order->netto + ( $order->netto / 100 * $order->vat );
      Order::where('id', $order->id)->update(['origin_order_json' => json_encode($order->toArray(), JSON_HEX_APOS)]);
    endforeach;

    $req = $this->request(self::api_orders_send_url, [ 'orders' => $orders->toArray() ]);

    $orders = $req['body'] ?? [];

    foreach($orders as $o):
      if(trim(strtolower($o['Crm_Status'])) == 'success'):
        $wb_number = $o['Web_Number'] ?? 0;
        $order = Order::where(['id'=>$o['Web_Id']])->orWhere(['crm_id'=>$o['WB_Id']])->first();
        $order->update([
          'crm_id' => $o['WB_Id'],
          'wb_id' => $o['Web_Number'],
          'netto' => $o['Netto_Sum'],
          'brutto' => $o['Brutto_Sum'],
          'vat' => $o['Mw_St'],
          'crm_status' => $o['Crm_Status'],
          'modified' => date('Y-m-d H:i:s'),
        ]);
      endif;
    endforeach;

    return $wb_number;
  }

  public function syncGetOrders() {
    $req = $this->request(self::api_orders_get_url);
    $orders = $this->cast_to_object($req['body']);
    foreach($orders as $order):
		$order_id = $this->orderUpdateOrInsert($order);
		if($order_id):
			foreach($order->Products as $product):
				$order_product = $this->orderProductUpdateOrInsert($product, $order_id, $order->Web_Client_Id);
			endforeach;
		endif;
    endforeach;
    echo "<pre>";
    var_dump($req);
    echo "</pre>";
    exit();
  }

  public function syncGetUsersInvoices() {
    $res = $this->request(self::api_users_invoices_url);
    $invoices = $res['body'] ?? [];
    foreach($invoices as $invoice):
      if(!$invoice['id']) continue;
      Invoice::updateOrCreate([
        'id' => $invoice['id']
      ],[
        'invoice_id' => $invoice['id'],
        'invoice_num' => "RE ".$invoice['number'] ?? "RE ".$invoice['id'],
        'kunden_id' => $invoice['clientId'] ?? 0,
        'vat' => $invoice['vat'] ?? 0,
        'amount_netto' => $invoice['netto_sum'] ?? 0,
        'amount' => $invoice['brutto_sum'] ?? 0,
        'paid' => $invoice['paid_sum'] ?? 0,
        'comment' => $invoice['comment'] ?? null,
        'date' => @date('Y-m-d H:i:s', @strtotime($invoice['changedDate'])) ?? date('Y-m-d H:i:s'),
      ]);
    endforeach;
    dd($res);
  }

  public function syncGetUsersPayments() {
    $res = $this->request(self::api_users_payments_url);
    $clients = $res['body'] ?? [];
    foreach($clients as $client):
      if(!$client['clientId']) continue;
      User::where('KundenId', $client['clientId'])->update([
        'balance' => $client['currentBalance'] ?? 0,
        'deposit' => $client['currentDepositLimit'] ?? 0,
        'deposit_available' => $client['currentDepositAvailable'] ?? 0,
        'debt' => $client['currentDebt'] ?? 0,
      ]);
      $transactions = $client['payments'] ?? [];
      $invoices = $client['invoices'] ?? [];
		foreach($transactions as $transaction):
			if(!$transaction['id']) continue;
			Transaction::updateOrCreate([
			  'id' => $transaction['id']
			],[
			  'kunden_id' => $transaction['clientId'] ?? 0,
			  'vat' => $transaction['vat'] ?? 0,
			  'amount_netto' => $transaction['netto_sum'] ?? 0,
			  'amount' => $transaction['brutto_sum'] ?? 0,
			  'balance' => $transaction['balance'] ?? 0,
			  'debt' => $transaction['debt'] ?? 0,
			  'comment' => $transaction['comment'] ?? null,
			  'date' => date('Y-m-d H:i:s', @strtotime($transaction['paymentdDate'])) ?? date('Y-m-d H:i:s'),
			  'type' => $transaction['type'] == 1 ? 0 : 1,
			  'block' => $transaction['blocked'] ?? $transaction['deleted'] ?? 0,
			]);
		endforeach;
      	Invoice::where('kunden_id', $client['clientId'])->delete();
		foreach($invoices as $invoice):
			if(!$invoice['id']) continue;
			Invoice::updateOrCreate([
				'id' => $invoice['id']
			],[
				'invoice_id' => $invoice['id'],
				'invoice_num' => "RE ".$invoice['number'] ?? "RE ".$invoice['id'],
				'kunden_id' => $invoice['clientId'] ?? 0,
				'vat' => $invoice['vat'] ?? 0,
				'amount_netto' => $invoice['netto_sum'] ?? 0,
				'amount' => $invoice['brutto_sum'] ?? 0,
				'paid' => $invoice['paid_sum'] ?? 0,
				'status' => $invoice['status'] ?? 0,
				'comment' => $invoice['comment'] ?? null,
				'date' => @date('Y-m-d H:i:s', @strtotime($invoice['invoiceDate'])) ?? date('Y-m-d H:i:s'),
			]);
		endforeach;
    endforeach;
    dd($res);
  }

  public function syncGetUsers() {
    $res = $this->request(self::api_users_sync_url);
    $now = date('Y-m-d H:i:s');
    $usersChanged = [];
    if($res['body'] && !empty($res['body'])):
      foreach($res['body'] as $user):
        // if(!(int)$user['DiscountVisibility']):
        //   DB::table('crm_clientdiscountgroups')->where(['ClientId' => $user['Id']])->delete();
        // endif;
        $entity = User::where(['KundenId' => $user['Id']])->first();
        if($entity):
          $entity->update([
            'name' => $user['FirstName'] ?? 0,
            'fname' => $user['FirstName'] ?? 0,
            'lname' => $user['LastName'] ?? 0,
            'login' => $user['Login'] ?? 0,
            'pass' => $user['Password'] ?? 0,
            'country' => $user['CountryId'] ?? 0,
            'block' => filter_var($user['Block'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'active' => filter_var($user['New'], FILTER_VALIDATE_BOOLEAN) ? 0 : 1,
            'DefLang' => $user['DefLang'] ?? 0,
            'male' => (int)$user['Gender'] ? 'M' : 'W',
            'KundenCode' => $user['ClientString'] ?? 0,
            'KundenId' => $user['Id'] ?? 0,
            'company' => $user['Company'] ?? 0,
            'town' => $user['City'] ?? 0,
            'street' => $user['Street'] ?? 0,
            'zip' => $user['Zip'] ?? 0,
            'phone' => $user['Phone'] ?? 0,
            'email' => $user['Email'] ?? 0,
            // 'AutoClient' => $user['AutoClient'],
            'balance' => $user['Balance'] ?? 0,
            'deposit_available' => $user['DepositAvailable'] ?? 0,
            'deposit' => $user['DepositLimit'] ?? 0,
            'debt' => $user['Debt'] ?? 0,
            'dateModify' => $now,
          ]);
        else:
          $entity = User::create([
            'name' => $user['FirstName'] ?? 0,
            'fname' => $user['FirstName'] ?? 0,
            'lname' => $user['LastName'] ?? 0,
            'login' => $user['Login'] ?? 0,
            'pass' => $user['Password'] ?? 0,
            'country' => $user['CountryId'] ?? 0,
            'block' => filter_var($user['Block'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'active' => filter_var($user['New'], FILTER_VALIDATE_BOOLEAN) ? 0 : 1,
            'DefLang' => $user['DefLang'] ?? 0,
            'male' => (int)$user['Gender'] ? 'M' : 'W',
            'KundenCode' => $user['ClientString'] ?? 0,
            'KundenId' => $user['Id'] ?? 0,
            'company' => $user['Company'] ?? 0,
            'town' => $user['City'] ?? 0,
            'street' => $user['Street'] ?? 0,
            'zip' => $user['Zip'] ?? 0,
            'phone' => $user['Phone'] ?? 0,
            'email' => $user['Email'] ?? 0,
            // 'AutoClient' => $user['AutoClient'],
            'balance' => $user['Balance'] ?? 0,
            'deposit_available' => $user['DepositAvailable'] ?? 0,
            'deposit' => $user['DepositLimit'] ?? 0,
            'debt' => $user['Debt'] ?? 0,
            'dateCreate' => $now,
            'dateModify' => $now,
          ]);
        endif;
        $usersChanged[] = $user['Id'];
      endforeach;
      $submit = $this->request(self::api_users_sync_complete_url, ['updated'=>$usersChanged]);
    endif;
    var_dump($res, $usersChanged);
    return null;
  }

  public function syncSendUser($user) {
    $new_user = [
    	"Name"       => $user['fname'],
    	"Surname"    => $user['lname'],
    	"Company"    => $user['company'],
    	"Street"     => $user['street'],
    	"Town"       => $user['town'],
    	"Country"    => $user['country'],
    	"Phone"      => $user['phone'],
      	"Email"      => $user['email'],
      	"Login"      => $user['login'],
    	"Password"   => $user['pass'],
    ];
    $response = $this->request(self::api_registration_url, $new_user);
    if($response['status'] == self::api_success):
      $kunden_id = is_array($response['body']) ? $response['body']['Id'] : json_decode($response['body'], true)['Id'];
      return ['KundenId'=>$kunden_id, 'error'=>null, 'status'=>$response['status']];
    else:
      return ['KundenId'=>null, 'error'=>$this->getError($response['status']), 'status'=>$response['status']];
    endif;
    return $response;
  }

  public function getError($errno) {
    return
    array_key_exists($errno, self::api_responses)
    ? self::api_responses[$errno]
    : self::api_responses[0];
  }

  private function request($url, array $data = []) {
    $data = json_encode($data);
    $error = null;
    $status = 500;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Token: ' . self::api_auth_token]);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "json=".$data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if($curl_errno = curl_errno($curl)):
        $error = 'curl error. errno: ' . $curl_errno . '. errstr: ' . curl_strerror($curl_errno);
    endif;
    curl_close($curl);

    $result = json_decode($response, true);

    switch(json_last_error()):
        case JSON_ERROR_NONE:
          $status = isset($result['StatusCode']) ? $result['StatusCode'] : $status;
          $result = isset($result['ResponseData']) ? $result['ResponseData'] : [];
        break;
        default:
          $result = $response;
          $error = "json parse error";
        break;
    endswitch;

    if(!is_array($result) || $status != 200):
      echo "<br> Request: <br>";
      var_export($url . "?json=".$data);
      echo "<br> Server terminated with response: <br>";
      var_export($response);
      exit();
    endif;

    return [ 'status'=>$status, 'body'=>$result, 'error'=>$error ];
  }

  public function findProductsSync($query = '') {
    $kunden_id = Session::get('kunden_id');
    $query = array_filter(is_array($query) ? $query : [$query]);
    return $query ? $this->apiSearchGetList($query, $kunden_id) : false;
  }

  public function findProductsNoSync($query='', array $fields, $producer = false, $strict = false) {
    if(empty($fields)) return [];
    $kunden_id = Session::get('kunden_id');
    $sync = false;
    $conditions = $this->searchBuildConditions($query, $fields, $producer, true);
    $results = DB::select($this->searchBuildQuery($kunden_id, $conditions));
    if(empty($results) && !$strict):
      $conditions = $this->searchBuildConditions($query, $fields, $producer, false);
      $results = DB::select($this->searchBuildQuery($kunden_id, $conditions));
    endif;
    return $results;
  }

  public function findProductsWithSync($query='', array $fields, $producer = false) {
    if(empty($fields)) return [];
    $kunden_id = Session::get('kunden_id');
    $sync = false;
    $conditions = $this->searchBuildConditions($query, $fields, $producer, true);
    $results = [];
    if(empty($results)):
      $sync = $this->apiSearchGetList([$query], $kunden_id);
      $results = DB::select($this->searchBuildQuery($kunden_id, $conditions));
    endif;
    if(empty($results)):
      $conditions = $this->searchBuildConditions($query, $fields, $producer, false);
      $results = DB::select($this->searchBuildQuery($kunden_id, $conditions));
    endif;
    return $results;
  }

  private function searchBuildConditions($query, $fields, $producer = false, $strict = false) {
    $condition = '';
    $condition .= '(';
    foreach ($fields as $i => $field):
      $condition .= $i ? " OR " : "";
      $condition .= $strict ? "$field = '$query'" : "$field LIKE '%$query%'";
    endforeach;
    $condition .= ')';
    if($producer):
      $condition .= is_int($producer) ? " AND MF.Id = '$producer' " : " AND MF.Name LIKE '%$producer%' ";
    endif;
    return $condition;
  }

  private function searchBuildQuery($kunden_id, $condition) {
    return "SELECT DISTINCT P.*,
    IF(CDG.Factor, P.Price * CDG.Factor, 0) as user_price,
    IF(CDG.Factor, P.WsPrice * CDG.Factor, 0) as user_price_ws,
    IF(CDG.Factor, P.WsQty * CDG.Factor, 0) as user_qty_ws,
    IF(CDG.Factor, CDG.Factor, 0) as factor,
    IF(CDG.Factor, CDG.Visibility, 0) as factor_visibility,
    IF(DG.Name, CONCAT(MF.Name, ' ', DG.Name), 0) as factor_group,
    MF.Name as producer_name,
    MF.Logo as producer_logo,
    DG.Comment as DGComment,
    IFNULL(DG.OwnerSupplierId, 0) as DGOwner,
    0 as in_stock
    FROM crm_products AS P
    LEFT JOIN osc_users AS U ON U.KundenId = $kunden_id
    LEFT JOIN crm_clientdiscountgroups AS CDG ON (CDG.DiscountGroupId = P.DiscountGroupId AND CDG.ClientId = U.KundenId)
    LEFT JOIN crm_discountgroups AS DG ON (DG.Id = P.DiscountGroupId AND DG.ProducerId = P.ProducerId)
    LEFT JOIN crm_producers AS MF ON MF.Id = P.ProducerId
    WHERE $condition
    GROUP BY IF(DG.OwnerSupplierId > 0, DG.OwnerSupplierId, P.Id)
    ORDER BY MF.Name, DG.OwnerSupplierId DESC, P.Code
    LIMIT 20";
  }

  public function apiSearchGetList($query) {
    $req = $this->request(self::api_products_find_url, [ 'Products' => $query ]);
    $res = $req['body'];
    if($res && !empty($res['Products'])):
      $products = $this->cast_to_object($res['Products']);
      foreach($products as $product):
        Product::where(['Id'=>$product->Id])->delete();
        Product::create([
          'Id' => $product->Id,
          'WsQty' => $product->ExtraQuant,
          'WsPrice' => $product->ExtraPrice,
          'ProducerId' => $product->ProducerId,
          'DiscountGroupId' => $product->DiscountGroupId,
          'Code' => $product->Code,
          'Price' => $product->Price,
          'Details' => $product->Details,
          'Weight' => $product->Weight,
          'Note' => $product->Note,
          'AltCode' => $product->AltCode,
          'AltCode2' => $product->AltCode2,
          'Deleted' => $product->Deleted,
          'Block' => $product->Block,
          'Created' => $product->Created,
          'Modified' => $product->Modified,
          'CreatedUserId' => $product->CreatedUserId,
          'ModifiedUserId' => $product->ModifiedUsedId,
          'Sizes' => '',
        ]);
      endforeach;
      return true;
    endif;
    return false;
  }

  public function orderUpdateOrInsert($order) {
    $now = date('Y-m-d H:i:s');
    $entity = Order::where(['id'=>$order->Web_Id])->orWhere(['crm_id'=>$order->WB_Id])->first();
    if($entity):
      $entity->update([
          'crm_id' => $order->WB_Id,
          'wb_id' => $order->Order_Name,
          'netto' => $order->Netto_Sum,
          'brutto' => $order->Brutto_Sum,
          'vat' => ($order->Mw_St * 100),
          'status' => $order->Order_Status_Id,
          'editable' => ($order->Order_Has_AB ? 0 : 1),
          'payment_status' => $order->Payment_Status,
          'payment_amount' => $order->Payment_Sum,
          'modified' => $now,
      ]);
    else:
      $entity = Order::create([
          'crm_id' => $order->WB_Id,
          'wb_id' => $order->Order_Name,
          'user_id' => $order->Web_Client_Id,
          'kunden_id' => $order->Client_Id,
          'netto' => $order->Netto_Sum,
          'brutto' => $order->Brutto_Sum,
          'vat' => ($order->Mw_St * 100),
          'status' => $order->Order_Status_Id,
          'editable' => ($order->Order_Has_AB ? 0 : 1),
          'payment_status' => $order->Payment_Status,
          'payment_amount' => $order->Payment_Sum,
          'modified' => $now,
          'created' => $now,
      ]);
    endif;
    return $entity->id;
  }

  public function orderProductUpdateOrInsert($product, $order_id, $user_id = 0) {
    $now = date('Y-m-d H:i:s');
    $product->RelationId = $product->RelationId ?? 0;
    $op = OrderProduct::updateOrCreate([
      'id'=>$product->RelationId,
      'order_id'=>$order_id,
    ],[
      'product_id'=>$product->Id,
      'user_id' => $user_id,
      'qty' => $product->Quant_WB,
      'stop' => (int)$product->Stop_Status,
      'code' => $product->Code,
      'qty_ab' => (int)$product->Quant_AB,
      'changed_code' => $product->Replacement_Code ?? null,
      'changed_code_id' => $product->Replacement_Code_Id ?? 0,
      'in_stock' => (int)$product->In_Stock_Count,
      'sent' => (int)$product->Sent_Count,
      'comment' => $product->Client_Comment,
      'comment_m' => $product->User_Comment,
      'history' => json_encode($product->Product_History, JSON_HEX_APOS),
      'price' => $product->Netto_Price,
      'modified' => $now,
      'created' => $now,
    ]);
    return null;
  }

  public function productUpdateOrInsert($product) {
    $now = date('Y-m-d H:i:s');
    $entity = Product::updateOrCreate([
      'Id'=>$product->Id
    ], [
      'WsQty' => $product->ExtraQuant,
      'WsPrice' => $product->ExtraPrice,
      'ProducerId' => $product->ProducerId,
      'DiscountGroupId' => $product->DiscountGroupId,
      'Code' => $product->Code,
      'Price' => $product->Price,
      'Details' => $product->Details,
      'Weight' => $product->Weight,
      'Note' => $product->Note,
      'AltCode' => $product->AltCode ?? null,
      'AltCode2' => $product->AltCode2 ?? null,
      'Deleted' => $product->Deleted,
      'Block' => $product->Block,
      'Created' => $product->Created,
      'Modified' => $now,
      'CreatedUserId' => $product->CreatedUserId,
      'ModifiedUserId' => $product->ModifiedUsedId,
      'Sizes' => isset($product->Sizes) ? $product->Sizes : '',
    ]);
    return ($entity ? $product->Id : 0);
  }

  private function cast_to_array($object) {
    $o = [];
    foreach($object as $k => $v):
       if(strlen($k)):
         $o[$k] = is_object($v) ? $this->cast_to_array($v) : $v;
       endif;
    endforeach;
    return json_decode(json_encode($o), true);
  }

  private function cast_to_object($array) {
    $o = new \stdClass;
    foreach($array as $k => $v):
       if(strlen($k)):
           $o->{$k} = is_array($v) ? $this->cast_to_object($v) : $v;
       endif;
    endforeach;
    return $o;
  }

}
