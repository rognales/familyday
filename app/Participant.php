<?php

namespace App;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected static $minSlugLength = 15;
    protected static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected $appends = ['meal_option'];

    public function dependants()
    {
        return $this->hasMany('App\Dependant');
    }

    public function qr()
    {
        return route('attend', ['slug' => $this->slug()]);
    }

    public function payment()
    {
        return $this->hasOne('App\User', 'id', 'payment_by')->withDefault();
    }

    public function softDeletedBy()
    {
        return $this->hasOne('App\User', 'id', 'deleted_by');
    }

    public function attend()
    {
        return $this->hasOne('App\User', 'id', 'attend_by')->withDefault();
    }

    public function adultsFamily()
    {
        return $this->hasMany('App\Dependant')->family()->adult();
    }

    public function kidsFamily()
    {
        return $this->hasMany('App\Dependant')->family()->kids();
    }

    public function infantsFamily()
    {
        return $this->hasMany('App\Dependant')->family()->infant();
    }

    public function adults()
    {
        return $this->hasMany('App\Dependant')->adult();
    }

    public function kids()
    {
        return $this->hasMany('App\Dependant')->kids();
    }

    public function infants()
    {
        return $this->hasMany('App\Dependant')->infant();
    }

    public function othersAdults()
    {
        return $this->hasMany('App\Dependant')->others()->where('age', '>', 10);
    }

    public function othersKids()
    {
        return $this->hasMany('App\Dependant')->others()->whereBetween('age', [3, 10]);
    }

    public function othersInfants()
    {
        return $this->hasMany('App\Dependant')->others()->where('age', '<', 3);
    }

    public function isPaid()
    {
        return $this->payment_status != 'Pending';
    }

    public function isAttended()
    {
        return $this->attend;
    }

    public function getMealOptionAttribute()
    {
        return $this->is_vege ? 'Vegetarian' : 'Normal';
    }

    public function markAttendance()
    {
        $this->attend = 1;
        $this->attended_by = Auth::user()->id;
        $this->attend_timestamp = now();
        $this->save();
    }

    public function sendConfirmationEmail()
    {
        return Mail::to($this->email)->send(new RegistrationConfirmation($this));
    }
}
