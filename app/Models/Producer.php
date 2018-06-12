<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $table = 'crm_producers';
    protected $primaryKey = 'Id';
    public $incrementing = true; /* set to false to use a non-incrementing primary key */
    public $timestamps = false; /* expects created_at & updated_at as timestamp values */
    // public $dateFormat = 'U'; /* format of refactored timestamps */
    // public $connection = ''; /* to use another db connection */
    protected $fillable = [
		'Id',
		'Name',
		'Logo',
		'WebSync',
		'WebModified',
		'Deleted',
		'Block',
		'Created',
		'Modified',
		'CreatedUserId',
		'ModifiedUserId',
		'IsVag',
		'New',
    ];
}
