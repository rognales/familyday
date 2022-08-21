<?php

namespace App;

use App\Services\EntranceRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Dependant extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($dependant) {
            if (Str::lower($dependant->relationship) === 'oku') {
                return $dependant->price = config('familyday.rate.oku.others');
            }

            return $dependant->price = EntranceRate::calculate($dependant->age, $dependant->member, $dependant->relationship === 'Others');
        });
    }

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function participant()
    {
        return $this->belongsTo(Participant::class)->withDefault();
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
        return $query->where('age', '>', config('familyday.age.adult.from'));
    }

    public function scopeKids($query)
    {
        return $query->whereBetween('age', [config('familyday.age.kids.from'), config('familyday.age.adult.to')]);
    }

    public function scopeInfant($query)
    {
        return $query->whereBetween('age', [config('familyday.age.infant.from'), config('familyday.age.infant.to')]);
    }

    public function getPriceAttribute($value)
    {
        return number_format($value / 100, 2);
    }
}
