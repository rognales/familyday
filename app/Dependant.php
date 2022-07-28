<?php

namespace App;

use App\Services\EntranceRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getPriceAttribute($value)
    {
        return number_format($value / 100, 2);
    }
}
