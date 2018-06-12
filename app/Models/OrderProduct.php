<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'crm_orders_products';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
      'crm_id',
      'order_id',
      'user_id',
      'product_id',
      'changed_code',
      'changed_code_id',
      'code',
      'price',
      'qty',
      'qty_ab',
      'in_stock',
      'sent',
      'stop',
      'comment',
      'comment_m',
      'vin',
      'history',
      'status',
      'created',
      'modified',
      'removed',
    ];
}
