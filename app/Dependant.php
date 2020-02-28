<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Dependant extends Model
{
   use SoftDeletes;
   protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

   public function member()
   {
      return $this->belongsTo('App\Participant')->withDefault();
   }

   public function participant()
   {
      return $this->belongsTo('App\Participant')->withDefault();
   }

   public function scopeOthers($query)
   {
      return $query->whereRelationship('Others');
   }

   public function scopeFamily($query)
   {
      return $query->where('relationship', '<>', 'Others');
   }

   public function scopeAdult($query)
   {
      return $query->where('age', '>', 10);
   }

   public function scopeKids($query)
   {
      return $query->whereBetween('age', [3, 10]);
   }

   public function scopeInfant($query)
   {
      return $query->where('age', '<', 3);
   }
}
