<?php
namespace App\Http\Controllers;

use DB;
use App;
use Config;
use Cookie;
use Session;
use Response;
use Mail;
use App\User;
use App\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailTemplates as Templates;

class ApiController extends Controller
{
  private $responses;

  public function index( $action, Request $request )
  {
    $res = ['StatusCode' => '200', 'ResponseData' => []];

    if($action === 'sync_orders_get'):
      $res['ResponseData'] = [1,2,3,4,5];
    endif;

    return response()->json($res, 200);
  }

}
