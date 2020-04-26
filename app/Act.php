<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\DateFormatter;

class Act extends Model
{
    /**
    * @var array
    */
    protected $fillable = [
        'act',
        'started_at',
        'ended_at',
        'number',
        'time',
        'contract_id',
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
    * @param string $value
    */
    public function getStartedAtAttribute($value): string
    {
        return DateFormatter::shortDate($value);
    }

    /**
    * @param string $value
    */
    public function getEndedAtAttribute($value): string
    {
        return DateFormatter::shortDate($value);
    }
}
