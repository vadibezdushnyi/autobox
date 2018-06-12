<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;
use DB;

class User extends Authenticatable
{
  protected $table = 'osc_users';
  protected $primaryKey = 'id';
  public $incrementing = true; /* set to false to use a non-incrementing primary key */
  public $timestamps = false; /* expects created_at & updated_at as timestamp values */
  // public $dateFormat = 'U'; /* format of refactored timestamps */
  // public $connection = ''; /* to use another db connection */

  protected $fillable = [
    'id',
    'type',
    'login',
    'email',
    'pass',
    'name',
    'fname',
    'lname',
    'male',
    'phone',
    'company',
    'street',
    'town',
    'zip',
    'country',
    'website',
    'turnover',
    'profile',
    'birthday',
    'comm_сount',
    'sale_card_id',
    'sale_barcode',
    'sale_percent',
    'delivery_address',
    'avatar',
    'data',
    'reg_ip',
    'last_login_ip',
    'last_visit',
    'dateCreate',
    'dateModify',
    'adminMod',
    'block',
    'active',
    'order_id',
    'Factor',
    'KundenCode',
    'KundenId',
    'DefLang',
    'balance',
    'deposit_available',
    'deposit',
    'debt',
  ];

  protected $hidden = [

  ];

  private static $user_id = 0;
  private static $kunden_id = 0;

  public static function establish() {
    self::$user_id = Session::has('user_id') ? (int)Session::get('user_id') : 0;
    self::$kunden_id = Session::has('kunden_id') ? (int)Session::get('kunden_id') : 0;
  }

  public static function entity() {
    $user = self::where('id',self::$user_id)->first();
    if($user):
      $user->refills = DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>0])->sum('amount');
      $user->writeoffs = DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>1])->sum('amount');
      // $user->balance = ceil($user->refills - $user->writeoffs);
      // $user->debt = $user->balance < 0 ? abs($user->balance) : 0;
      // $user->balance = $user->balance < 0 ? 0 : abs($user->balance);
      // $user->deposit = ceil($user->deposit - $user->debt);
      // $user->limit = $user->deposit + $user->balance;
      $user->limit = $user->deposit_available;
    endif;
    return $user;
  }

  public static function invoices() {
    $invoices = (object)[];
    $invoices->list = DB::table('crm_users_invoices')->where(['kunden_id'=>self::$kunden_id])->orderBy('date', 'desc')->get();
    $invoices->size = sizeof($invoices->list);
    $invoices->amount = 0;
    $invoices->total = 0;
    $invoices->paid = 0;
    foreach($invoices->list as &$invoice):
      $invoice->total = $invoice->amount + ($invoice->amount * $invoice->vat);
      if($invoice->paid == 0):
        $invoice->state = 3;
        $invoice->state_class = 'status-waiting';
      elseif($invoice->paid < $invoice->total):
        $invoice->state = 2;
        $invoice->state_class = 'status-in-progress';
      else:
        $invoice->state = 1;
        $invoice->state_class = 'status-complete';
      endif;
      if($invoice->status == 4):
        $invoice->state_class .= ' canceled';
      endif;
      $invoices->amount += $invoice->amount;
      $invoices->total += $invoice->total;
      $invoices->paid += $invoice->paid;
    endforeach;
    return $invoices;
  }

  public static function moneyflow() {
    $moneyflow = (object)[];
    $moneyflow->operations = DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id])->orderBy('date', 'desc')->get();
    $moneyflow->size = sizeof($moneyflow->operations);
    $moneyflow->received = DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>0])->sum('amount');
    $moneyflow->writtenoff = DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>1])->sum('amount');
    return $moneyflow;
  }

  public static function refills() {
    return DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>0])->orderBy('date', 'desc')->get();
  }

  public static function writeoffs() {
    return DB::table('crm_users_moneyflow')->where(['kunden_id'=>self::$kunden_id,'type'=>1])->orderBy('date', 'desc')->get();
  }

}
