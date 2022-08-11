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
            // If price already exists, skipped adjusting price
            if ($participant->price > 0) {
                return;
            }

            // Always adult price
            $participant->price = EntranceRate::calculate(21, $participant->member);

            return $participant;
        });

        static::saved(function ($participant) {
            // Always adult price
            $participant->permalink = route('registration_show', $participant);

            return $participant;
        });
    }

    protected $appends = ['meal_option'];

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected static $minSlugLength = 15;

    // protected static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected $casts = [
        'attend_timestamp' => 'datetime',
    ];

    public function dependants()
    {
        return $this->hasMany(Dependant::class);
    }

    public function qr()
    {
        return route('attend', ['slug' => $this->slug()]);
    }

    public function payment()
    {
        return $this->hasOne(User::class, 'id', 'payment_by')->withDefault();
    }

    public function softDeletedBy()
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }

    public function attendee()
    {
        return $this->hasOne(User::class, 'id', 'attended_by')->withDefault();
    }

    public function adultsFamily()
    {
        return $this->hasMany(Dependant::class)->family()->adult();
    }

    public function kidsFamily()
    {
        return $this->hasMany(Dependant::class)->family()->kids();
    }

    public function infantsFamily()
    {
        return $this->hasMany(Dependant::class)->family()->infant();
    }

    public function adults()
    {
        return $this->hasMany(Dependant::class)->adult();
    }

    public function kids()
    {
        return $this->hasMany(Dependant::class)->kids();
    }

    public function infants()
    {
        return $this->hasMany(Dependant::class)->infant();
    }

    public function othersAdults()
    {
        return $this->hasMany(Dependant::class)->others()->where('age', '>', 10);
    }

    public function othersKids()
    {
        return $this->hasMany(Dependant::class)->others()->whereBetween('age', [3, 10]);
    }

    public function othersInfants()
    {
        return $this->hasMany(Dependant::class)->others()->where('age', '<', 3);
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
