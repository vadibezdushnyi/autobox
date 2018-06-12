<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'crm_users_moneyflow';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'id',
      'kunden_id',
      'vat',
      'amount_netto',
      'amount',
      'balance',
      'debt',
      'comment',
      'date',
      'type',
      'block',
    ];
}
