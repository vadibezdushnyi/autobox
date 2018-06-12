<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountGroup extends Model
{
    protected $table = 'crm_discountgroups';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'Id',
      'ProducerId',
      'Name',
      'PrimarySupplierId',
      'OwnerSupplierId',
      'WebSync',
      'Deleted',
      'Comment',
      'Block',
      'Created',
      'Modified',
      'CreatedUserId',
      'ModifiedUserId',
    ];
}
