<?php

namespace App;

class Event extends Model
{
  public function participants(){

    return $this->hasMany('App\Participant');
  }
}
