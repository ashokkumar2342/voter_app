<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WardPanchayat extends Model
{
      
      protected $fillable=['id'];
      protected $table='ward_ps';
      public $timestamps=false;

       
      public function Districts()
      {
             return $this->hasOne('App\Model\District','id','district_id');
      }
       
}