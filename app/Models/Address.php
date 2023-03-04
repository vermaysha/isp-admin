<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Vermaysha\Wilayah\Models\Village;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'village_id',
        'postal_code',
        'address_line',
        'coordinates',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'village:id,district_code,name',
        'village.district:code,city_code,name',
        'village.district.city:code,province_code,name',
        'village.district.city.province:code,name',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['district', 'city', 'province', 'full_address'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'coordinates' => Point::class,
    ];

    /**
     * Village relationship
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get current district
     */
    public function district(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->village->district;
            }
        );
    }

    /**
     * Get current city
     */
    public function city(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->village->district->city;
            }
        );
    }

    /**
     * Get province
     */
    public function province(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->village->district->city->province;
            }
        );
    }

    /**
     * Get full address
     */
    public function fullAddress(): Attribute
    {
        return Attribute::make(
            function () {
                return sprintf(
                    '%s, %s, %s, %s',
                    $this->village->name,
                    $this->district->name,
                    ucwords(strtolower($this->city->name)),
                    ucwords(strtolower($this->province->name)),
                );
            }
        );
    }
}
