<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;

class Servant extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'servant',
        'registration',
        'birthed_at',
        'natural_from',
        'marital_status',
        'mother_name',
        'father_name',
        'CPF',
        'RG',
        'PIS',
        'CTPS',
        'title',
        'address',
        'phone',
        'email',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependents()
    {
        return $this->hasMany(Dependent::class, 'servant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'servant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenses()
    {
        return $this->hasMany(License::class, 'servant_id');
    }

    /**
     * @param string $value
     */
    public function getBirthedAtAttribute($value): string
    {
        return DateTimeFormatter::format($value);
    }

    /**
     * @param string $value
     */
    public function getCreatedAtAttribute($value): string
    {
        return DateTimeFormatter::format($value);
    }

    /**
     * @param string $value
     */
    public function getUpdatedAtAttribute($value): string
    {
        return DateTimeFormatter::format($value);
    }

    /**
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Collection<\App\Servant>
     */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Servant::query()->where('name', 'LIKE', $searchTerm)->orWhere('CPF', 'LIKE', $searchTerm)->get();
        }

        return Servant::all();
    }
}
