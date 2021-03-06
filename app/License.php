<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;

class License extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'registration',
        'start_date',
        'finish_date',
        'license_type',
        'days',
        'servant_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servant()
    {
        return $this->belongsTo(Servant::class, 'servant_id');
    }

    /**
     * @param string $value
     */
    public function getStartDateAttribute($value): string
    {
        return DateTimeFormatter::format($value);
    }

    /**
     * @param string $value
     */
    public function getFinishDateAttribute($value): string
    {
        return DateTimeFormatter::format($value);
    }
}
