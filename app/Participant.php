<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Balping\HashSlug\HasHashSlug;

class Participant extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    protected $guarded = ['id','created_at','updated_at','deleted_at'];
    protected $dates = ['deleted_at'];
    protected static $minSlugLength = 8;

    public function dependants(){

      return $this->hasMany('App\Dependant');
    }

    public function event(){

       return $this->belongsTo('App\Event');
    }

    public function qr(){
      return route('attend', ['slug' => $this->slug()]);
    }

    public function payment(){

       return $this->hasOne('App\User','id','payment_by')->withDefault();
    }

    public function softDeletedBy(){

       return $this->hasOne('App\User','id','deleted_by'); //->select('name','username');
    }

    public function attend(){

       return $this->hasOne('App\User','id','attend_by')->withDefault();
    }

    public function adultsFamily(){
      return $this->hasMany('App\Dependant')->family()->adult();
    }

    public function kidsFamily(){
      return $this->hasMany('App\Dependant')->family()->kids();
    }

    public function infantsFamily(){
      return $this->hasMany('App\Dependant')->family()->infant();
    }

    public function adults(){
      return $this->hasMany('App\Dependant')->adult();
    }

    public function kids(){
      return $this->hasMany('App\Dependant')->kids();
    }

    public function infants(){
      return $this->hasMany('App\Dependant')->infant();
    }

    public function othersAdults(){
      return $this->hasMany('App\Dependant')->others()->where('age','>',10);
    }

    public function othersKids(){
      return $this->hasMany('App\Dependant')->others()->whereBetween('age',[3,10]);
    }

    public function othersInfants(){
      return $this->hasMany('App\Dependant')->others()->where('age','<',3);
    }

}
