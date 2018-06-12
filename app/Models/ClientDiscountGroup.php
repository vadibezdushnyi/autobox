<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDiscountGroup extends Model
{
    protected $table = 'crm_clientdiscountgroups';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'Id',
      'Name',
      'ClientId',
      'DiscountGroupId',
      'Factor',
      'Created',
      'Modified',
      'Visibility',
    ];
}
