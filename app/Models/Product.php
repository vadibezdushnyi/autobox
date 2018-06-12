<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'crm_products';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'Id',
      'WsQty',
      'WsPrice',
      'ProducerId',
      'DiscountGroupId',
      'Code',
      'Price',
      'Details',
      'Weight',
      'Sizes',
      'Note',
      'AltCode',
      'AltCode2',
      'Deleted',
      'Block',
      'Created',
      'Modified',
      'CreatedUserId',
      'ModifiedUserId',
    ];
}
