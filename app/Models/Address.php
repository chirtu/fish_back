<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'contact_name',
        'phone_number',
        'optional_phone_number',
        'number',
        'code',
        'trimedCode',
        'latitude',
        'longitude',
        'postcode',
        'customer_id',
        'region_id',
        'district_id',
        'ward_id',
        'street_id',
        'street_road_id',
        'isDefault',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }

    public function streetRoad(): BelongsTo
    {
        return $this->belongsTo(StreetRoad::class);
    }
}
