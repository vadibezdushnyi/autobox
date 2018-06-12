<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'crm_users_invoices';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
      'id',
      'kunden_id',
      'invoice_id',
      'invoice_num',
      'vat',
      'amount',
      'amount_netto',
      'paid',
      'comment',
      'status',
      'date',
    ];
}
