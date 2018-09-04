<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class M_Religion extends Model
{
    public $timestamps = false;
    protected $connection = 'pgsql';
    protected $table = 'religion';
    protected $primaryKey = 'religion_id'; // or Null
    protected $table_name = 'religion';

    protected $fillable = [
        'religion_name',
        'religion_crdate',
        'religion_update',
        'religion_dldate'
    ];
}
