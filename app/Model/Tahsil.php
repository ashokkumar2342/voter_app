<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tahsil extends Model
{
	
   protected $fillable=[
   	'id',];
   	public $timestamps = false;

   	public function district()
    {
      	 return $this->hasOne('App\Model\District','id','district_id');
    }
}
