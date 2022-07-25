<?php

namespace App;

use App\Mail\PaymentConfirmation;
use App\Mail\RegistrationConfirmation;
use App\Services\EntranceRate;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Participant extends Model
{
    use HasHashSlug;
    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($participant) {
            // Always adult price
            return $participant->price = EntranceRate::calculate(21, $participant->member);
        });
    }

    protected $appends = ['meal_option'];

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected static $minSlugLength = 15;

    // protected static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected $casts = [
        'member' => 'boolean',
    ];

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

    /**
     * Get all of the uploads for the Participant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function isPaid()
    {
        return $this->payment_status != 'Pending';
    }

    public function isAttended()
    {
        return $this->attend;
    }

    public function isMember()
    {
        return $this->member;
    }

    public function getMealOptionAttribute()
    {
        return $this->is_vege ? 'Vegetarian' : 'Normal';
    }

    public function getIsMemberAttribute()
    {
        return $this->member ? 'Yes!' : 'No';
    }

    public function hasPaid()
    {
        return $this->payment_status === 'Paid';
    }

    public function getPriceAttribute($value)
    {
        return number_format($value / 100, 2);
    }

    public function getTotalPriceAttribute()
    {
        $subTotal = $this->dependants()->sum('price');
        $total = $subTotal + $this->getRawOriginal('price');
        // dd( $subTotal, $this->getRawOriginal('price'), $total);
        return number_format($total / 100, 2);
    }

    public function markAttendance()
    {
        $this->attend = 1;
        $this->attended_by = Auth::user()->id;
        $this->attend_timestamp = now();
        $this->save();
    }

    public function markAsPaid($details)
    {
        $this->payment_status = 'Paid';
        $this->payment_details = $details;
        $this->payment_timestamp = now();
        $this->payment_by = auth()->user()->id;
        $this->save();
    }

    public function sendConfirmationEmail()
    {
        return Mail::to($this->email)->send(new RegistrationConfirmation($this));
    }

    public function sendPaymentConfirmationEmail()
    {
        return Mail::to($this->email)->send(new PaymentConfirmation($this));
    }
}
